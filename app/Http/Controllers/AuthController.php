<?php

namespace App\Http\Controllers;

use App\Events\UserRegister;
use App\Http\Requests\PostChangePassword;
use App\Http\Requests\PostCreateNewPassword;
use App\Http\Requests\PostLogin;
use App\Http\Requests\PostRegister;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function viewLogin(): View
    {
        return View('auth.login');
    }

    public function viewRegister(): View
    {
        return View('auth.register');
    }

    public function postRegister(PostRegister $request): Redirector|Application|RedirectResponse
    {
        $email = $request->input('email');
        $fullName = $request->input('full_name');
        $password = Str::random(8);

        $user = $this->userRepository->create([
            'email' => $email,
            'full_name' => $fullName,
            'password' => Hash::make($password),
            'avatar' => env('URL_SERVER') . '/images/default-avatar.png',
        ]);

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->save();

        event(new UserRegister($email, $password));

//        Mail::send('mails.send-password', compact('password'), function ($data) use ($email) {
//            $data->to($email, 'Chat App')->subject('Your password');
//        });

        return redirect('/auth/login')->with('registerSuccess', 'Please check your email to get your password.');
    }

    public function postLogin(PostLogin $request): Application|RedirectResponse
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        if (Auth::attempt($credentials, $request->input('remember'))) {
            return redirect('/');
        } else {
            return redirect('/auth/login')->with('loginError', 'Email or password is incorrect.');
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function googleRedirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function viewCreateNewPassword(): View
    {
        return View('auth.create_new_password');
    }

    public function viewChangePassword(): View
    {
        return View('auth.change_password');
    }

    public function postChangePassword(PostChangePassword $request)
    {
        try {
            $user = Auth::user();
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('password'));
                $user->save();

                return redirect('/');
            }

            return redirect()->back()->with('changePasswordError', 'Mật khẩu cũ chưa chính xác');
        } catch (\Exception $e) {
            return redirect()->back()->with('changePasswordError', $e->getMessage());
        }
    }


    public function postCreateNewPassword(PostCreateNewPassword $request): RedirectResponse
    {
        $user = Auth::user();
        // Create New Password
        $user->password = Hash::make($request->input('password'));
        $user->login_first = false;
        $user->save();
        return redirect('/');
    }

    public function googleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                Auth::login($user);

                if ($user->login_first) {
                    return redirect('/auth/create-new-password');
                }

                return redirect('/');
            }

            $user = User::create([
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make('password'),
                'full_name' => $googleUser->getName(),
                'avatar' => $googleUser->getAvatar()
            ]);

            Profile::create([
                'user_id' => $user->id,
            ]);

            Auth::login($user);
            return redirect('/auth/create-new-password');

        } catch (\Exception $exception) {
            return redirect()->route('login');
        }
    }
}
