<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;

class NotificationController extends Controller
{
    public function getNewMessagesCount()
    {
        $userId = auth()->id();

        $newMessagesCount = Ticket::where('user_id', $userId)
            ->where('status', '1')
            ->count();
        return response()->json(['newMessagesCount' => $newMessagesCount]);
    }

    public function getTickets()
    {
        $userId = auth()->id();

        $tickets = Ticket::where('user_id', $userId)
            ->where('status', '1')
            ->orderBy('updated_at', 'desc')
            ->get();

        $tickets->each(function ($ticket) {
            $admin = User::find($ticket->admin_id);
            $ticket->admin_first_name = $admin ? $admin->first_name : 'Admin';
        });

        return response()->json(['tickets' => $tickets]);
    }
}