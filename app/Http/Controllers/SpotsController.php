<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSpot;
use App\Models\Image;
use App\Models\SpotLocation;
use App\Models\HostDetail;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;

class SpotsController extends Controller
{
    public function showSpots()
    {
        $userId = Auth::id();
    
        $hostDetail = HostDetail::where('user_id', $userId)->first();
        if (!$hostDetail) {
            return redirect()->back()->with('error', 'Host details not found.');
        }
    
        $hostId = $hostDetail->host_id;
    
        $spots = ParkingSpot::where('host_id', $hostId)
            ->where('status', '!=', 'rejected')
            ->get();
    
        foreach ($spots as $spot) {
            // Fetch image for the spot from the Image table
            $image = Image::where('spot_id', $spot->spot_id)->first();
            
            if ($image && $image->image_url) {
                // Extract file ID from the image URL
                preg_match('/id=([a-zA-Z0-9_-]+)/', $image->image_url, $matches);
                
                $spot->image_url = isset($matches[1]) 
                    ? 'https://drive.google.com/file/d/' . $matches[1] . '/preview'  // Use preview URL for iframe
                    : asset('storage/default.jpg');
                
                // Add original image URL for debugging
                $spot->original_image_url = $image->image_url;
            } else {
                // No image found for the spot
                $spot->image_url = asset('storage/default.jpg');
                $spot->original_image_url = null;
            }
            
            $spot->location = SpotLocation::where('spot_id', $spot->spot_id)->first();
            $spot->availability = Availability::where('spot_id', $spot->spot_id)->get();
        }
        return view('dashboard.spots', compact('spots'));
    }
}
       