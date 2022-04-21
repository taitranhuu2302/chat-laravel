<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostChangePassword;
use App\Http\Requests\PostLogin;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function viewLogin(): View
    {
        return View('auth.login');
    }

    public function postLogin(PostLogin $request): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
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

    public function postChangePassword(PostChangePassword $request): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
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
