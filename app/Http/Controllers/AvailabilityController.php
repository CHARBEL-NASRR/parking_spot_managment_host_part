<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSpot;
use App\Models\Availability;

class AvailabilityController extends Controller
{
    public function showAvailabilityForm($spot_id)
    {
        if ($spot_id) {
            $spot = ParkingSpot::where('spot_id', $spot_id)->firstOrFail();
        } 

        return view('createspot.availability', compact('spot'));
    }

    public function saveAvailability(Request $request)
    {
        $request->validate([
            'day.*' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time_availability.*' => 'required|date_format:H:i',
            'end_time_availability.*' => 'required|date_format:H:i|after:start_time_availability.*',
        ]);
    
        foreach ($request->day as $index => $day) {
            $dayMapping = [
                'Monday' => 1,
                'Tuesday' => 2,
                'Wednesday' => 3,
                'Thursday' => 4,
                'Friday' => 5,
                'Saturday' => 6,
                'Sunday' => 7,
            ];
            $dayNumeric = $dayMapping[$day] ?? null;
    
            if ($dayNumeric !== null) {
                $startTime = date('H:i:s', strtotime($request->start_time_availability[$index]));
                $endTime = date('H:i:s', strtotime($request->end_time_availability[$index]));
    
                // Check if the availability already exists for the spot and day
                $availability = Availability::where('spot_id', $request->spot_id)->first();
    
                if ($availability) {
                    // Update if the availability already exists
                    $availability->update([
                        'day' => $dayNumeric,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ]);
                } else {
                    // Create new availability if it doesn't exist
                    Availability::create([
                        'spot_id' => $request->spot_id,
                        'day' => $dayNumeric,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ]);
                }
            }
        }
    
        // Update the spot status
        $spot = ParkingSpot::where('spot_id', $request->spot_id)->firstOrFail();
        $spot->update([
            'status' => '0',
        ]);
        
        return redirect()->route('price.form', ['spot_id' => $spot->spot_id]);
    }
    
}
