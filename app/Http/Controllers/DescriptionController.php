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
        $spot = ParkingSpot::where('host_id', $user->user_id)
                           ->where('spot_id', $spot_id)
                           ->first();

        if (!$spot) {
            abort(404, 'Spot not found');
        }

        return view('createspot.description', compact('spot')); // Pass the spot to the view
    }

    public function saveDescription(Request $request, $spot_id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $user = auth()->user(); // Get the authenticated user

        // Find the specific spot by ID
        $spot = ParkingSpot::where('host_id', $user->user_id)
                           ->where('spot_id', $spot_id)
                           ->first();

        if ($spot) {
            // Update the description of the existing spot
            $spot->update(['main_description' => $request->description]);
        }

        return redirect()->route('images.form'); // Redirect to images form
    }

  public function updateTitle(Request $request, $spot_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $spot = ParkingSpot::findOrFail($spot_id);
        $spot->title = $request->input('title');
        $spot->save();

        return response()->json(['message' => 'Title updated successfully'], 200);
    }
}