<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSpot;

class DescriptionController extends Controller
{
    public function showDescriptionForm($spot_id)
    {
        $user = auth()->user(); // Get authenticated user
        $spot = ParkingSpot::where('host_id', $user->user_id)
                           ->where('spot_id', $spot_id) // Get spot by spot_id
                           ->first();

        return view('createspot.description', compact('spot')); // Pass the spot data to the view
    }

    public function saveDescription(Request $request, $spot_id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $user = auth()->user(); // Get the authenticated user

        // Find the specific spot and update the description
        $spot = ParkingSpot::where('spot_id', $spot_id)
                           ->where('host_id', $user->user_id)
                           ->first();

        if ($spot) {
            $spot->update(['main_description' => $request->description]); // Update description
        }

        return redirect()->route('images.form'); // Redirect to images form
    }
}
