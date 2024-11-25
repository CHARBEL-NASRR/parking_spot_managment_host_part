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
        return view('createspot.description', compact('spot')); // Pass the spot to the view
    }
    
    public function store(Request $request, $spot_id)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'city' => 'required|string',
            'district' => 'required|string',
        ]);

        // Insert into spotLocation table
        spotLocation::create([
            'spot_id' => $spot_id,
            'address' => $validated['address'],
            'city' => $validated['city'],
            'district' => $validated['district'],
        ]);

        // Update the ParkingSpot table
        $spot = ParkingSpot::where('spot_id', $spot_id)->first();
        if ($spot) {
            $spot->update([
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);
        }

        return redirect()->back()->with('success', 'Location saved successfully!');
    }
}