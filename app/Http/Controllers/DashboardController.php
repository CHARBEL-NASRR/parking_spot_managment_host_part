<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\HostDetail;
use App\Models\ParkingSpot;
use App\Models\Spot;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getLastBookings(Request $request)
    {
        try {
            $days = $request->input('days', 30); // Default to last 30 days if not provided
            $startDate = Carbon::now()->subDays($days);
    
            $userId = auth()->id(); 
    
            // Retrieve the host details for the authenticated user
            $host = HostDetail::where('user_id', $userId)->first();
    
            if (!$host) {
                return response()->json(['error' => 'Host not found'], 404);
            }
    
            // Retrieve bookings associated with the host's parking spots
            $bookings = Booking::select(
                    'bookings.booking_id',
                    'bookings.guest_id',
                    'bookings.spot_id',
                    'bookings.start_time',
                    'bookings.end_time',
                    'bookings.status',
                    'bookings.total_price',
                    'bookings.created_at',
                    'parking_spots.title as spot_title'
                )
                ->join('parking_spots', 'bookings.spot_id', '=', 'parking_spots.spot_id')
                ->where('parking_spots.host_id', $host->host_id)
                ->where('bookings.created_at', '>=', $startDate)
                ->orderBy('bookings.created_at', 'desc')
                ->get();
    
            // Add guest name to each booking
            $bookings->each(function ($booking) {
                $guest = User::find($booking->guest_id);
                $booking->guest_name = $guest ? $guest->name : 'Guest';
            });
    
            return response()->json(['bookings' => $bookings]);
    
        } catch (\Exception $e) {
            \Log::error('Error retrieving last bookings: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
    
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    

    public function getRevenueData()
{
    try {
        $userId = auth()->id(); 
        \Log::info('User ID for revenue data: ' . $userId);

        $host = HostDetail::where('user_id', $userId)->first();
        
        if (!$host) {
            \Log::error('No host found for user ID: ' . $userId);
            return response()->json(['error' => 'Host not found'], 404);
        }

        $revenues = Booking::select(
                'bookings.spot_id', 
                DB::raw('DATE(bookings.created_at) as date'), 
                DB::raw('SUM(bookings.total_price) as total')
            )
            ->join('parking_spots', 'bookings.spot_id', '=', 'parking_spots.spot_id')
            ->where('parking_spots.host_id', $host->host_id)
            ->whereIn('bookings.status', ['accepted'])
            ->groupBy('date', 'bookings.spot_id')
            ->orderBy('date', 'asc')
            ->get();

        \Log::info('Revenues retrieved: ' . $revenues->count() . ' records');

        return response()->json($revenues);

    } catch (\Exception $e) {
        \Log::error('Revenue data retrieval error: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());

        return response()->json([
            'error' => 'An unexpected error occurred',
            'message' => $e->getMessage()
        ], 500);
    }
}


public function getMonthlyIncome()
{
    $userId = auth()->id(); 
    $host = HostDetail::where('user_id', $userId)->first(); 
    
    $monthlyIncome = Booking::join('parking_spots', 'bookings.spot_id', '=', 'parking_spots.spot_id')
        ->where('parking_spots.host_id', $host->host_id)
        ->whereIn('bookings.status', ['accepted'])
        ->whereBetween('bookings.created_at', [now()->startOfMonth(), now()->endOfMonth()])
        ->sum('bookings.total_price');

    return response()->json($monthlyIncome);
}

public function getDailyIncome()
{
    $userId = auth()->id(); 
    $host = HostDetail::where('user_id', $userId)->first(); 
    
    $dailyIncome = Booking::join('parking_spots', 'bookings.spot_id', '=', 'parking_spots.spot_id')
        ->where('parking_spots.host_id', $host->host_id)
        ->whereIn('bookings.status', ['accepted'])
        ->whereDate('bookings.created_at', today())
        ->sum('bookings.total_price');

    return response()->json($dailyIncome);
}

public function getDealsCompleted()
{
    $userId = auth()->id(); 
    $host = HostDetail::where('user_id', $userId)->first(); 
    
    $dealsCompleted = Booking::join('parking_spots', 'bookings.spot_id', '=', 'parking_spots.spot_id')
        ->where('parking_spots.host_id', $host->host_id)
        ->where('bookings.status', 'accepted')
        ->count();

    return response()->json($dealsCompleted);
}

public function getOverallRating()
{
    $userId = auth()->id(); 
    $host = HostDetail::where('user_id', $userId)->first(); 
    
    $spots = ParkingSpot::where('host_id', $host->host_id)->get();
    $averageRating = $spots->avg('overall_rating');

    return response()->json($averageRating);
}


}