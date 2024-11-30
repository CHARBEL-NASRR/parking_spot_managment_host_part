<?php

namespace App\Http\Controllers;

use Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('google_id', $googleUser->id)->orWhere('email', $googleUser->getEmail())->first();

            if ($user) {
                Auth::login($user);
                
            } else {
                $user = User::create([
                    'first_name' => $googleUser->user['given_name'],
                    'last_name' => $googleUser->user['family_name'],
                    'email' => $googleUser->getEmail(),
                    'phone_number' => $googleUser->user['phone'] ?? 'N/A', 
                    'password' => Hash::make(Str::random(16)), 
                    'google_id' => $googleUser->id, 
                    'validate_token' => 0,
                    'expired_date' => Carbon::now()->addDays(2),
                    'is_valid' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                Auth::login($user);
                $token = $user->createToken('Personal Access Token')->accessToken;
            }
            session(['google_drive_access_token' => $googleUser->token]);
            session(['google_drive_refresh_token' => $googleUser->refreshToken]);
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login.form')->with('error', 'Something went wrong. Please try again.');
        }
    }
}