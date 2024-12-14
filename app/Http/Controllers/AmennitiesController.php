<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpotAmenities; // Import the SpotAmenities model
use App\Models\ParkingSpot; // Import the ParkingSpot model
use Illuminate\Support\Facades\Log;

class AmennitiesController extends Controller
{
    // Show the amenities form
    public function showAmenitiesForm(Request $request)
    {
        // Retrieve the spot_id from the request
        $spot_id = $request->input('spot_id');

        // Retrieve the parking spot based on host_id and spot_id
        $spot = ParkingSpot::where('host_id', session('host_id'))
                           ->where('spot_id', $spot_id)
                           ->first();

        // If the spot is not found, redirect to an error page
        if (!$spot) {
            Log::error('ParkingSpot not found for spot_id: ' . $spot_id);
            return redirect()->route('error.page')->withErrors(['error' => 'Parking spot not found']);
        }

        // Return the view with the spot data
        return view('createspot.amenities', compact('spot'));
    }

    // Submit the amenities form
    public function submitAmenities(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'amenities' => 'required|array',
            'spot_id' => 'required|exists:parking_spots,spot_id', 
        ]);

        // Retrieve the host ID from the session
        $hostId = session('host_id');

        // Retrieve the spot based on spot_id
        $spot = ParkingSpot::where('spot_id', $request->spot_id)->first();

        // If the spot is not found, log an error and redirect back with an error message
        if (!$spot) {
            Log::error('ParkingSpot not found for spot_id: ' . $request->spot_id);
            return redirect()->back()->withErrors(['error' => 'Parking spot not found']);
        }

        // Define the amenities data from the request
        $amenities = [
            'is_covered' => in_array('Cover', $request->amenities),
            'has_security' => in_array('Security', $request->amenities),
            'has_ev_charging' => in_array('EV Charging', $request->amenities),
            'is_handicap_accessible' => in_array('Handicap', $request->amenities),
            'has_lighting' => in_array('Light', $request->amenities),
            'has_cctv' => in_array('CCTV', $request->amenities),
            'is_gated' => in_array('Gate', $request->amenities),
        ];

        // Check if the spot amenities already exist for this spot_id
        $spotAmenities = SpotAmenities::where('spot_id', $spot->spot_id)->first();

        if ($spotAmenities) {
            // If the record exists, update it
            foreach ($amenities as $key => $value) {
                $spotAmenities->$key = $value;
            }

            // Save the updated record
            if (!$spotAmenities->save()) {
                throw new \Exception('Failed to update spot amenities');
            }
        } else {
            // If the record doesn't exist, create a new one
            $spotAmenities = new SpotAmenities();
            $spotAmenities->spot_id = $spot->spot_id;

            // Save the new record
            foreach ($amenities as $key => $value) {
                $spotAmenities->$key = $value;
            }

            if (!$spotAmenities->save()) {
                throw new \Exception('Failed to save spot amenities');
            }
        }

        // Redirect based on whether the spot is gated or not
        if ($spotAmenities->is_gated) {
            return redirect()->route('pin.form', ['spot_id' => $spot->spot_id]);
        }

        return redirect()->route('title.form', ['spot_id' => $spot->spot_id]);
    }
}
