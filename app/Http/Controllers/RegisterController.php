<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use App\Mail\SignupValidationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255', 
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255', 
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        
        $user = new User([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $request->input('phone'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'status' => "Pending",
            'google_id' => null,
            'validate_token' => $this->gen_uuid(), 
            'is_valid' => false,
            'expired_date' => Carbon::now()->addDays(2),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


    $user->save();
    if ($user->user_id) {
        $userrole = new UserRole([
            'user_id' => $user->user_id, 
            'role_id' => 2,           
        ]);
    
        $userrole->save();
    } else {
        dd('User ID is not set properly');
    }


        $this->sendValidationEmail($user);

        return redirect()->back()->with('success', 'Signup successful!');
    }



    public function sendValidationEmail($user){
        $validationUrl =  $user->validate_token;
        Mail::to($user->email)->send(new SignupValidationMail($validationUrl));
    }



    public function validateToken($token)
    {
        $user = User::where('validate_token', $token)
                    ->where('expired_date', '>=', Carbon::now())
                    ->first();

        if (!$user) {
            return redirect()->route('signup')->with('error', 'Invalid or expired validation link.');
        }

        $user->is_valid = true;
        $user->validate_token = null; 
        $user->save();
        return redirect()->route('login.form')->with('success', 'Your account has been validated successfully! Please log in.');
    }


    public function showLoginForm() {
        return view('login'); 
    }




    protected function gen_uuid() {
    $uuid = sprintf('%s-%s-%s-%s-%s',
        bin2hex(random_bytes(4)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(6))
    );
    return $uuid;
    }
}
