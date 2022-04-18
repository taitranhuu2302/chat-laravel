<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\NoReturn;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function viewLogin(): View
    {
        return View('auth.login');
    }

    public function googleRedirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                Auth::login($user);
                return redirect('/');
            }

            $user = User::create([
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make('password')
            ]);

            $profile = Profile::create([
                'user_id' => $user->id,
                'full_name' => $googleUser->getName(),
                'avatar' => $googleUser->getAvatar()
            ]);

            $user->profile()->save($profile);

            Auth::login($user);
            return redirect('/');

        } catch (\Exception $exception) {
            return redirect()->route('login');
        }
    }
}
