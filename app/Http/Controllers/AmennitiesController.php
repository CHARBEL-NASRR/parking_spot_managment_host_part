<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpotAmenities; // Import the SpotAmenities model
use App\Models\ParkingSpot; // Import the ParkingSpot model
use Illuminate\Support\Facades\Log;

class AmennitiesController extends Controller
{
    // Show the amenities form
    public function showAmenitiesForm()
    {
            $host_id = session('host_id');
        return view('createspot.amentities');
    }

    // Handle form submission
public function submitAmenities(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'is_covered' => 'nullable|in:on',
        'has_security' => 'nullable|in:on',
        'has_ev_charging' => 'nullable|in:on',
        'is_handicap_accessible' => 'nullable|in:on',
        'has_lighting' => 'nullable|in:on',
        'has_cctv' => 'nullable|in:on',
    ]);

    try {
        // Get the authenticated user
        $user = auth()->user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        // Retrieve the host_id from the host_details table using the user_id
        $hostDetail = \App\Models\HostDetail::where('user_id', $user->user_id)->first();
        if (!$hostDetail) {
            throw new \Exception('Host details not found for user_id: ' . $user->user_id);
        }
        $host_id = $hostDetail->host_id;

        // Create a new ParkingSpot or retrieve an existing one if spot_id is passed
        $spot_id = $request->query('spot_id');
        $spot = null;

        if ($spot_id) {
            // Find the existing spot by ID
            $spot = ParkingSpot::where('host_id', $host_id)
                               ->where('spot_id', $spot_id)
                               ->first();
            if (!$spot) {
                throw new \Exception('Parking spot not found for spot_id: ' . $spot_id);
            }
        } else {
            // Create a new spot if no spot_id is provided
            $spot = ParkingSpot::create([
                'host_id' => $host_id, // Use host_id from host_details
            ]);
            if (!$spot) {
                throw new \Exception('Failed to create new parking spot');
            }
        }

        // Create the SpotAmenities record
        $spotAmenities = new SpotAmenities();
        $spotAmenities->spot_id = $spot->spot_id; // Use the spot_id from ParkingSpot
        $spotAmenities->is_covered = $request->has('is_covered');
        $spotAmenities->has_security = $request->has('has_security');
        $spotAmenities->has_ev_charging = $request->has('has_ev_charging');
        $spotAmenities->is_handicap_accessible = $request->has('is_handicap_accessible');
        $spotAmenities->has_lighting = $request->has('has_lighting');
        $spotAmenities->has_cctv = $request->has('has_cctv');

        // Save the SpotAmenities record
        if (!$spotAmenities->save()) {
            throw new \Exception('Failed to save spot amenities');
        }

        // Optionally log the successful submission
        Log::info('Spot amenities successfully saved for spot ID: ' . $spotAmenities->spot_id);

        // Return a success message or redirect
        return redirect()->route('title.form', ['spot_id' => $spot->spot_id]);
    } catch (\Exception $e) {
        // Log the error and return a failure response
        Log::error('Error saving spot amenities: ' . $e->getMessage());
        return back()->with('error', 'An error occurred while saving amenities: ' . $e->getMessage());
    }
}
}