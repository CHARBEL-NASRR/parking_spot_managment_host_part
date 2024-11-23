<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ParkingSpot;

class createtitleController extends Controller
{
    public function showTitleForm()
    {
        $user = auth()->user(); // Get the authenticated user
        $spot = ParkingSpot::where('host_id', $user->user_id)
                           ->whereNull('title') // If title is not set yet
                           ->first();

        return view('createspot.title', compact('spot')); // Pass the spot data to the view
    }

    public function saveTitle(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $user = auth()->user(); // Get the authenticated user

        // Find the existing spot or create a new one if necessary
        $spot = ParkingSpot::updateOrCreate(
            ['host_id' => $user->user_id, 'spot_id' => $request->spot_id ?? null], // Check for existing or new spot
            ['title' => $request->title] // Save the title
        );

        return redirect()->route('description.form', ['spot_id' => $spot->spot_id]); // Pass spot_id to description form
    }
}
