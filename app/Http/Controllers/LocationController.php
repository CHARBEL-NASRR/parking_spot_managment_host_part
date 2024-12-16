<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\spotLocation;
use App\Models\ParkingSpot;

class LocationController extends Controller
{

    public function showLocationForm($spot_id)
    {
        $user = auth()->user(); 
        $spot = ParkingSpot::where('spot_id', $spot_id)
                           ->first();
        return view('createspot.google_map', compact('spot')); // Pass the spot to the view
    }
    
    public function saveLocation(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'city' => 'required|string',
            'address' => 'required|string',
            'district' => 'required|string',
        ]);

      
        $spotLocation = spotLocation::where('spot_id', $request->spot_id)->first();

        if ($spotLocation) {
            // If spot_id exists, update the record
            $spotLocation->update([
                'address' => $validated['address'],
                'city' => $validated['city'],
                'district' => $validated['district'],
            ]);
        } else {
            // If spot_id does not exist, create a new record
            spotLocation::create([
                'spot_id' => $request->spot_id,
                'address' => $validated['address'],
                'city' => $validated['city'],
                'district' => $validated['district'],
            ]);
        }
        

        // Update the ParkingSpot table
        $spot = ParkingSpot::where('spot_id', $request->spot_id)->first();
        if ($spot) {
            $spot->update([
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);
        }

        return redirect()->route('carSize.show', ['spot_id' => $spot->spot_id]);
    }
}
