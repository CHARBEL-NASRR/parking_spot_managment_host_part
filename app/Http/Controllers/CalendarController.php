<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Availability;
use App\Models\ParkingSpot;
use App\Models\HostDetail;

class CalendarController extends Controller
{
    public function showCalendar($spot_id = null) {
        $hostDetail = HostDetail::where('host_id', auth()->id())->first();
        if (!$hostDetail) {
            abort(404, 'Host details not found');
        }
        $host_id = $hostDetail->host_id;

        $spots = ParkingSpot::where('host_id', $host_id)->get();
        if (is_null($spot_id) || !$spots->contains('spot_id', $spot_id)) {
            $spot_id = $spots->first()->spot_id;
        }

        $availabilities = Availability::where('spot_id', $spot_id)->get();

        $events = $availabilities->flatMap(function ($availability) {
            return $this->generateWeeklyEvents($availability);
        });

        return view('dashboard.calendar', ['events' => $events, 'spots' => $spots, 'selected_spot_id' => $spot_id]);
    }

    private function generateWeeklyEvents($availability) {
        $events = [];
        $startTime = $availability->start_time_availability;
        $endTime = $availability->end_time_availability;
        $dayOfWeek = $availability->day;

        // Generate a single event for the correct day of the current week
        $date = new \DateTime();
        $date->setISODate((int)date('o'), (int)date('W'), $dayOfWeek);
        $events[] = [
            'id' => $availability->availability_id,
            'title' => $startTime . ' - ' . $endTime,
            'start' => $date->format('Y-m-d') . 'T' . $startTime,
            'end' => $date->format('Y-m-d') . 'T' . $endTime,
            'color' => 'green',
        ];

        return $events;
    }

    public function saveAvailability(Request $request) {
        $request->validate([
            'spot_id' => 'required|exists:parking_spots,spot_id',
            'day' => 'required|integer|between:0,6',
            'start_time_availability' => 'required|date_format:H:i:s',
            'end_time_availability' => 'required|date_format:H:i:s|after:start_time_availability',
        ]);

        $availability = new Availability();
        $availability->spot_id = $request->spot_id;
        $availability->start_time_availability = $request->start_time_availability;
        $availability->end_time_availability = $request->end_time_availability;
        $availability->day = $request->day;
        $availability->save();

        return redirect()->route('calendar', ['spot_id' => $request->spot_id]);
    }

    public function updateAvailability(Request $request) {
        $request->validate([
            'id' => 'required|exists:availability,availability_id',
            'spot_id' => 'required|exists:parking_spots,spot_id',
            'day' => 'required|integer|between:0,6',
            'start_time_availability' => 'required|date_format:H:i:s',
            'end_time_availability' => 'required|date_format:H:i:s|after:start_time_availability',
        ]);

        $availability = Availability::find($request->id);
        $availability->start_time_availability = $request->start_time_availability;
        $availability->end_time_availability = $request->end_time_availability;
        $availability->day = $request->day;
        $availability->save();

        return redirect()->route('calendar', ['spot_id' => $request->spot_id]);
    }

    public function deleteAvailability(Request $request) {
        $request->validate([
            'id' => 'required|exists:availability,availability_id',
            'spot_id' => 'required|exists:parking_spots,spot_id',
        ]);

        $availability = Availability::find($request->id);
        $availability->delete();

        return redirect()->route('calendar', ['spot_id' => $request->spot_id]);
    }
}