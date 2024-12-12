<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Wallet;
use App\Models\ParkingSpot;
use App\Models\HostDetail;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;

class BookingController extends Controller
{
    public function getRequestedBookings()
    {
        Log::info('Fetching requested bookings');

        $userId = auth()->id();
        Log::info('Authenticated user_id: ' . $userId);

        $hostDetail = HostDetail::where('user_id', $userId)->first();
        if (!$hostDetail) {
            Log::warning('No host details found for user_id: ' . $userId);
            return response()->json(['error' => 'Host details not found'], 404);
        }

        $hostId = $hostDetail->host_id;
        Log::info('Host details found for user_id: ' . $userId . ', host_id: ' . $hostId);

        $spotIds = ParkingSpot::where('host_id', $hostId)->pluck('spot_id');
        Log::info('Spot IDs for host_id ' . $hostId . ': ' . $spotIds->implode(', '));

        $bookings = Booking::whereIn('spot_id', $spotIds)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $bookings->each(function ($booking) {
            $guest = User::find($booking->guest_id);
            $booking->guest_name = $guest ? $guest->first_name : 'Guest';
            $parkingSpot = ParkingSpot::find($booking->spot_id);
            if ($parkingSpot) {
                $host = User::find($parkingSpot->host_id);
                $booking->host_user_id = $host ? $host->id : null;
            } else {
                $booking->host_user_id = null;
            }
        });
        return response()->json(['bookings' => $bookings]);
    }




public function updateBookingStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|string|in:accepted,rejected',
    ]);

    $booking = Booking::findOrFail($id);

    $guest = User::find($booking->guest_id);

    $totalPrice = $booking->total_price;

    $guestWallet = Wallet::where('user_id', $guest->user_id)->first();
    if (!$guestWallet) {
        return redirect()->back()->with('error', 'Guest wallet not found.');
    }

    $userId = auth()->id();

    $hostDetail = HostDetail::where('user_id', $userId)->first();
    if (!$hostDetail) {
        return redirect()->back()->with('error', 'Host details not found.');
    }

    $hostId = $hostDetail->host_id;

    $hostWallet = Wallet::firstOrCreate(
        ['user_id' => $userId], 
        ['balance' => 0, 'last_updated' => now()]
    );

    if ($request->status == 'accepted') {
        if ($guestWallet->balance < $totalPrice) {
            $booking->status = 'rejected';
            $booking->save();
            return redirect()->back()->with('error', 'Insufficient funds. Booking rejected.');
        } else {
            $guestWallet->balance -= $totalPrice;
            $hostWallet->balance += $totalPrice;
            $guestWallet->save();
            $hostWallet->save();

            $booking->status = 'upcomming';
            $booking->save();


   
            // Create a transaction record
            Transaction::create([
                'sender_wallet_id' => $guestWallet->wallet_id,
                'receiver_wallet_id' => $hostWallet->wallet_id,
                'booking_id' => $booking->booking_id,
                'transaction_type' => 'upcoming',
                'deducted_amount' => $totalPrice,
                'received_amount' => $totalPrice,
                'commission_amount' => 0,
                'created_at' => now(),
                'ticket_id' => null,
            ]);

            return redirect()->back()->with('success', 'Booking accepted and payment processed.');
        }
    } elseif ($request->status == 'rejected') {
        $booking->status = 'rejected';
        $booking->save();
        return redirect()->back()->with('success', 'Booking rejected.');
    }

    return redirect()->back()->with('error', 'Invalid status.');
}


}