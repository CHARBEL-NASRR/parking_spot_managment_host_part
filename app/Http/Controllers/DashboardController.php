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
        $days = $request->input('days', 30); 
        $startDate = Carbon::now()->subDays($days);

        $userId = auth()->id(); 

        $host = HostDetail::where('user_id', $userId)->first();
        if (!$host) {
            return response()->json(['error' => 'Host not found'], 404);
        }

        $bookings = Booking::where('created_at', '>=', $startDate)
            ->where('host_id', $host->host_id) 
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
    $userId = auth()->id(); 

    $host = HostDetail::where('user_id', $userId)->first();
    if (!$host) {
        return response()->json(['error' => 'Host not found'], 404);
    }

    $revenues = Booking::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
        ->where('host_id', $host->host_id) 
        ->whereIn('status', ['accepted'])
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    return response()->json($revenues);
}



    public function getmonthlyprofit()
{
    $userId = auth()->id(); 
    $host = HostDetail::where('user_id', $userId)->first(); 
    $monthlyProfits = Booking::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_price) as total')
        ->whereIn('status', ['accepted']) 
        ->where('host_id', $host->host_id)
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    return response()->json($monthlyProfits);
}


  public function getdailyprofit()
{
    $userId = auth()->id(); 
    $host = HostDetail::where('user_id', $userId)->first(); 
    $dailyProfits = Booking::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
        ->whereIn('status', ['accepted'])
        ->where('host_id', $host->host_id)
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    return response()->json($dailyProfits);
}


  public function getdealcompleted()
{
    $userId = auth()->id(); 
    $host = HostDetail::where('user_id', $userId)->first(); 
    $acceptedBookings = Booking::whereIn('spot_id', $spotIds)
            ->where('status', 'accepted')
            ->where('host_id', $host->host_id)
            ->count();
   
    return $acceptedBookings;
}


   public function getoverallrating()
{
    $userId = auth()->id(); 
    $host = HostDetails::where('user_id', $userId)->first(); 
    $totalRating = $spots->sum('overall_rating')
                ->where('host_id', $host->host_id);

    $numberOfSpots = $spots->count();
    $averageRating = $numberOfSpots > 0 ? $totalRating / $numberOfSpots : 0;
    return $averageRating;
}





}