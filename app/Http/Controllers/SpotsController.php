<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSpot;
use App\Models\Image;
use App\Models\SpotLocation;
use App\Models\HostDetail;
use Illuminate\Support\Facades\Auth;

class SpotsController extends Controller
{
    public function showSpots()
    {
        // Get the authenticated user's ID (user_id)
        $userId = Auth::id();

        $hostDetail = HostDetail::where('user_id', $userId)->first();
        if (!$hostDetail) {
            return redirect()->back()->with('error', 'Host details not found.');
        }

        $hostId = $hostDetail->host_id;

        // Get the spots based on the host_id
        $spots = ParkingSpot::where('host_id', $hostId)->get();

        // Filter and update spot status
        $spots = $spots->filter(function ($spot) {
            if (empty($spot->status)) {
                $spot->status = 'pending';
            }
            return $spot->status !== 'rejected';
        });

        // Add image and address to each spot
        foreach ($spots as $spot) {
            $spot->image = Image::where('spot_id', $spot->spot_id)->first();
            $spot->address = SpotLocation::where('spot_id', $spot->spot_id)->first();
        }

        return view('dashboard.spots', compact('spots'));
    }


    
}