<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpotAmenities; // Import the SpotAmenities model
use App\Models\ParkingSpot; // Import the ParkingSpot model
use Illuminate\Support\Facades\Log;

class AmennitiesController extends Controller
{
    public function showAmenitiesForm(Request $request)
    {
        $spot_id = $request->input('spot_id');
        $spot = ParkingSpot::where('host_id', session('host_id'))
                            ->where('spot_id', $spot_id)
                            ->first();
        return view('createspot.amenities', compact('spot'));
    }

    public function submitAmenities(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'amenities' => 'required|array',
            'spot_id' => 'required|exists:parking_spots,spot_id', 
        ]);

        $hostId = session('host_id');

        $spot = ParkingSpot::where('spot_id', $request->spot_id)->first();
        if (!$spot) {
            Log::error('ParkingSpot not found for spot_id: ' . $request->spot_id);
            return redirect()->back()->withErrors(['error' => 'Parking spot not found']);
        }

        $amenities = [
            'is_covered' => in_array('Cover', $request->amenities),
            'has_security' => in_array('Security', $request->amenities),
            'has_ev_charging' => in_array('EV Charging', $request->amenities),
            'is_handicap_accessible' => in_array('Handicap', $request->amenities),
            'has_lighting' => in_array('Light', $request->amenities),
            'has_cctv' => in_array('CCTV', $request->amenities),
            'is_gated' => in_array('Gate', $request->amenities),
        ];

        $spotAmenities = new SpotAmenities();
        $spotAmenities->spot_id = $spot->spot_id;

        foreach ($amenities as $key => $value) {
            $spotAmenities->$key = $value;
        }

        if (!$spotAmenities->save()) {
            throw new \Exception('Failed to save spot amenities');
        }

        if ($spotAmenities->is_gated) {
            return redirect()->route('pin.form', ['spot_id' => $spot->spot_id]);
        }

        return redirect()->route('title.form', ['spot_id' => $spot->spot_id]);
    }
}
