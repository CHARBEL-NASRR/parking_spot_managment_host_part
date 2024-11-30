<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HostDetail;
use App\Models\ParkingSpot;
use Auth;

class ProfileController extends Controller
{
    public function showProfileForm()
    {
        $user = auth()->user();
        \Log::info('User ID: ' . $user->user_id);
        $hostDetail = HostDetail::where('user_id', $user->user_id)->first();

        if ($hostDetail) {
            $host_id = $hostDetail->host_id;
            $profilePictureUrl = $hostDetail->id_card;
            $spots = ParkingSpot::where('host_id', $host_id)->get();
            $totalRating = $spots->sum('overall_rating');
            $numberOfSpots = $spots->count();
            $averageRating = $numberOfSpots > 0 ? $totalRating / $numberOfSpots : 0;
        } else {
            $profilePictureUrl = 'default_image_url';
            $averageRating = 0;
        }
        return view('dashboard.profile', compact('user', 'profilePictureUrl', 'averageRating'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only('first_name', 'last_name', 'phone_number', 'email'));
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

}