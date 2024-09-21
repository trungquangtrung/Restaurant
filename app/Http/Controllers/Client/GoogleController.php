<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use League\OAuth1\Client\Server\User as ServerUser;

class GoogleController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }
    public function callback(){
        $userGoogle = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            [
                'google_user_id' => $userGoogle->id
            ],
            [
                'email' => $userGoogle->email,
                'name' => $userGoogle->name,
                'password' => Hash::make('password'),
                'google_user_id' => $userGoogle->id
            ]
        );

        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
