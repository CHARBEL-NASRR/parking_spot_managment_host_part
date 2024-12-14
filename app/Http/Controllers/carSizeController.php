<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Import the SpotAmenities model
use App\Models\ParkingSpot; // Import the ParkingSpot model
use Illuminate\Support\Facades\Log;

class carSizeController extends Controller{

    public function showCarSizeForm($spot_id){
        $user = auth()->user(); 
        $spot = ParkingSpot::where('spot_id', $spot_id)
                           ->first();
        return view('createspot.carSize', compact('spot'));
    }

    public function saveCarSize(Request $request) {
        $validated = $request->validate([
            'vehicle_type' => 'required|in:2wheeler,4wheeler,6wheeler,8wheeler', // Ensuring the value is one of the enum values
        ]);
        
        $spot = ParkingSpot::where('spot_id', $request->spot_id)->first();
        if ($spot) {
            $spot->update([
                'car_type' => $validated['vehicle_type'],
            ]);
        }
    
        return redirect()->route('availability.form', ['spot_id' => $spot->spot_id]);
    }
    

}