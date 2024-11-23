<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSpot;

class createtitleController extends Controller
{
    public function showTitleForm(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user

        // Retrieve the specific spot if `spot_id` is provided, or create a new one
        $spot_id = $request->query('spot_id');
        $spot = null;

        if ($spot_id) {
            // Find the existing spot by ID
            $spot = ParkingSpot::where('host_id', $user->user_id)
                               ->where('spot_id', $spot_id)
                               ->first();
        } else {
            // Create a new spot if no `spot_id` is provided
            $spot = ParkingSpot::create([
                'host_id' => $user->user_id,
            ]);
        }

        return view('createspot.title', compact('spot')); // Pass the spot to the view
    }

    public function saveTitle(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $user = auth()->user(); // Get the authenticated user

        // Find the specific spot or fail
        $spot = ParkingSpot::where('host_id', $user->user_id)
                           ->where('spot_id', $request->spot_id)
                           ->first();

        if ($spot) {
            // Update the title of the existing spot
            $spot->update(['title' => $request->title]);
        }

        return redirect()->route('upload_id.form'); // Redirect to description form
        //['spot_id' => $spot->spot_id]
    }
}