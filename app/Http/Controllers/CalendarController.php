<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Availability;
use App\Models\ParkingSpot;
use App\Models\HostDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class CalendarController extends Controller
{
public function showWeeklySchedule()
{
    // Get the logged-in user's ID
    $userId = auth()->user()->user_id;

    // Get the host_id associated with this user
    $hostDetail = HostDetail::where('user_id', $userId)->first();
    
    Log::info('Authenticated user_id: ' . $userId);
    Log::info('Authenticated user_id: ' . $hostDetail);


    // Get all parking spots for this host_id
    $spots = ParkingSpot::where('host_id', $hostDetail->host_id)->get();

    // Get the first spot for default selection
    $defaultSpot = $spots->first();

    // Fetch availability for the first spot (or use the default spot if any)
    $availability = Availability::where('spot_id', $defaultSpot->spot_id)
                                 ->select('availability_id','start_time', 'end_time', 'day')
                                 ->get();


    // Pass the spots and the default availability to the Blade view
    return view('dashboard.calendar', compact('spots', 'availability', 'defaultSpot'));
}

// Fetch availability times for a specific parking spot
public function getSpotAvailability($spotId)
{
    // Get all availability for the given spot_id
    $availability = Availability::where('spot_id', $spotId)
                                 ->select('availability_id','start_time', 'end_time', 'day')
                                 ->get();

    return response()->json($availability);
}


public function saveAvailability(Request $request) {
    $request->validate([
        'spot_id' => 'required|exists:parking_spots,spot_id',
        'day' => 'required|integer|between:0,6',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time_availability',
    ]);

    $availability = new Availability();
    $availability->spot_id = $request->spot_id;
    $availability->start_time = $request->start_time;
    $availability->end_time = $request->end_time;
    $availability->day = $request->day;
    $availability->save();

    Log::info('Availability saved: ' . $availability);
    return response()->json($availability);
}

public function updateAvailability(Request $request) {
    Log::info('Update request received', $request->all());
    $request->validate([
        'availability_id' => 'required|integer|exists:availability,availability_id',
        'spot_id' => 'required|exists:parking_spots,spot_id',
        'day' => 'required|integer|between:0,6',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time_availability',
    ]);

    $availability = Availability::find($request->availability_id);
    if (!$availability) {
        Log::error('Availability not found for ID: ' . $request->availability_id);
        return response()->json(['error' => 'Availability not found'], 404);
    }

    $availability->spot_id = $request->spot_id;
    $availability->start_time = $request->start_time;
    $availability->end_time = $request->end_time;
    $availability->day = $request->day;
    $availability->save();

    Log::info('Availability updated: ' . $availability);
    return response()->json($availability);
}



public function deleteAvailability(Request $request) {
    Log::info('Delete request received', $request->all());

    $request->validate([
        'availability_id' => 'required|integer|exists:availability,availability_id',
    ]);

    $availability = Availability::find($request->availability_id);
    if (!$availability) {
        Log::error('Availability not found for ID: ' . $request->availability_id);
        return response()->json(['error' => 'Availability not found'], 404);
    }

    $availability->delete();

    Log::info('Availability deleted: ' . $availability);
    return response()->json(['success' => true]);
}

}
