<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HostDetail;
use App\Models\ParkingSpot;
use App\Models\Wallet;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function showProfileForm()
    {

        $user = auth()->user();

        $hostDetail = HostDetail::where('user_id', $user->user_id)->first();

        if ($hostDetail) {
            $host_id = $hostDetail->host_id;

            $wallet = Wallet::where('user_id', $user->user_id)->first();
            $walletBalance = $wallet ? $wallet->balance : 0;
            $profilePictureUrl = 'https://drive.google.com/uc?export=view&id=' . $hostDetail->id_card;

            $spots = ParkingSpot::where('host_id', $host_id)->get();

            $totalRating = $spots->sum('overall_rating');
            $numberOfSpots = $spots->count();
            $averageRating = $numberOfSpots > 0 ? $totalRating / $numberOfSpots : 0;

            $spotIds = $spots->pluck('spot_id');
            $acceptedBookings = Booking::whereIn('spot_id', $spotIds)
                ->where('status', 'accepted')
                ->count();
        } else {
            $profilePictureUrl = 'default_image_url';
            $averageRating = 0;
            $walletBalance = 0; 
            $acceptedBookings = 0; 
        }

        return view('dashboard.profile', compact('user', 'profilePictureUrl', 'averageRating', 'walletBalance', 'acceptedBookings'));
    }




    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only('first_name', 'last_name', 'phone_number', 'email'));
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}