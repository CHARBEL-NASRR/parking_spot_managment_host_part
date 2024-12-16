<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use App\Models\HostDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use AuthenticatesUsers;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

       public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('host/login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'The provided email does not exist.']);
        }

        if (!$user->is_valid) {
            return redirect()->back()->withErrors(['email' => 'The email address is not validated.']);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()->back()->with('error', 'Email or password are not correct.');
        }
         $token = $user->createToken('Personal Access Token')->accessToken;
            Auth::login($user);
            $userRole = UserRole::where('user_id',  $user->user_id)->first();
    
            if ($userRole && $userRole->role_id == 2) {
                $hostDetail = HostDetail::where('user_id', $user->user_id)->first();
                if ($hostDetail) {
                    session(['host_id' => $hostDetail->host_id]);
                    return redirect()->route('dashboard');  
                } else {
                    return redirect()->route('upload_id.form');
                }   
            } else {
                return redirect()->back()->withErrors(['error' => 'You are not authorized to access this page.']);
            }   
        }
    }