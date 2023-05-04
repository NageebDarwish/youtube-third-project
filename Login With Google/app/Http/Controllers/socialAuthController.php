<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class socialAuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleCallback()
    {

        $google_user = Socialite::driver('google')->user();


        $user = User::where('google_id', $google_user->id)->first();
        if (!$user) {
            $user = User::Create([
                'google_id' => $google_user->id,
                'name' => $google_user->name,
                'email' => $google_user->email,
                'google_token' => $google_user->token,

            ]);
            return $user;
            Auth::login($user);
        } else {
            Auth::login($user);
            return $user;
        }
    }
}
