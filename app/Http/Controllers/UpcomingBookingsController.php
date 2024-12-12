<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\ParkingSpot;
use App\Models\SpotLocation;

class UpcomingBookingsController extends Controller
{
    public function getUpcomingBookings()
    {
        $bookings = Booking::where('status', 'upcoming')
            ->orderBy('start_time', 'asc')
            ->get();

        $bookings->each(function ($booking) {
            $guest = User::find($booking->guest_id);
            $booking->guest_name = $guest ? $guest->first_name : 'Guest';
            $spotLocation = SpotLocation::where('spot_id', $booking->spot_id)->first();
            $booking->spot_address = $spotLocation ? $spotLocation->address : 'Unknown';
        });

        return response()->json(['bookings' => $bookings]);
    }

    public function viewUpcomingBookings()
    {
        return view('dashboard.upcomming_bookings');
    }
}