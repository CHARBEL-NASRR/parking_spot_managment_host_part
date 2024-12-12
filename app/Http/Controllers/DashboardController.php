<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Spot;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getLastBookings(Request $request)
    {
        $days = $request->input('days', 30); // Default to last 30 days if not specified
        $startDate = Carbon::now()->subDays($days);

        $bookings = Booking::where('created_at', '>=', $startDate)
            ->orderBy('created_at', 'desc')
            ->get();

        $bookings->each(function ($booking) {
            $guest = User::find($booking->guest_id);
            $spot = Spot::find($booking->spot_id);
            $booking->guest_name = $guest ? $guest->name : 'Guest';
            $booking->spot_title = $spot ? $spot->title : 'Spot';
        });

        return response()->json(['bookings' => $bookings]);
    }


        public function getRevenueData()
    {
        // Fetch revenue data from the database
        // Adjust the query according to your database structure.
        $revenues = Booking::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->whereIn('status', ['accepted'])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($revenues);
    }


}