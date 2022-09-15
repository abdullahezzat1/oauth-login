<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    private $scopes = [
        'google' => ['openid', 'profile', 'email'],
        'facebook' => ['public_profile,email'],
        'github' => ['read:user'],
    ];

    public function viewHome()
    {
        if (session('logged_in')) {
            return redirect('/profile');
        }
        return view('home');
    }

    public function viewProfile()
    {
        if (!session('logged_in')) {
            return redirect('/');
        }
        return view('profile');
    }

    public function redirect($driver)
    {
        if (session('logged_in')) {
            return redirect('/');
        }
        return Socialite::driver($driver)->scopes($this->scopes[$driver])->redirect();
    }

    public function callback($driver)
    {
        $user = Socialite::driver($driver)->user();
        dd($user);
        session([
            'logged_in' => true,
            'email' => $user->getEmail(),
            'picture' => $user->getAvatar(),
            'name' => $user->getName(),
        ]);

        return redirect('/profile');
    }

    public function logout()
    {
        session()->invalidate();
        return redirect('/');
    }
}
