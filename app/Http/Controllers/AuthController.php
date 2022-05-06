<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostChangePassword;
use App\Http\Requests\PostLogin;
use App\Http\Requests\PostRegister;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    public function postRegister(PostRegister $request)
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

        Mail::send('mails.send-password', compact('password'),function($data) use ($email) {
            $data->to($email, 'Chat App')->subject('Your password');
        });

        return view('auth.login')->with('registerSuccess', 'Please check your email to get your password.');
    }

    public function postLogin(PostLogin $request): Application|RedirectResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect('/');
        } else {
            return redirect('/auth/login');
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

    public function viewChangePassword(): View
    {
        return View('auth.change_password');
    }

    public function postChangePassword(PostChangePassword $request): RedirectResponse
    {
        $user = Auth::user();
        // Create New Password
        $user->password = Hash::make($request->password);
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
                    return redirect('/auth/change-password');
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
            return redirect('/auth/change-password');

        } catch (\Exception $exception) {
            return redirect()->route('login');
        }
    }
}
