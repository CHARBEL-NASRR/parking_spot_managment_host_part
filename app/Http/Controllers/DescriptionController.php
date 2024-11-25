<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSpot;

class DescriptionController extends Controller
{
    public function showDescriptionForm($spot_id)
    {
        $user = auth()->user(); // Get the authenticated user

        // Find the specific spot by ID
        $spot = ParkingSpot::where('spot_id', $spot_id)
                           ->first();

    

        return view('createspot.description', compact('spot')); // Pass the spot to the view
    }

    public function saveDescription(Request $request, $spot_id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $user = auth()->user(); // Get the authenticated user

        // Find the specific spot by ID
        $spot = ParkingSpot::where('spot_id', $spot_id)
                           ->first();

        if ($spot) {
            // Update the description of the existing spot
            $spot->update(['main_description' => $request->description]);
        }

        return redirect()->route('images.form', ['spot_id' => $spot->spot_id]);
    }

}