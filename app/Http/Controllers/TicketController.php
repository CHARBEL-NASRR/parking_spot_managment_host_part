<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $ticket = new Ticket();
        $ticket->user_id = auth()->id();
        $ticket->admin_id = 0;
        $ticket->type = $request->type;
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->status = '0';
        $ticket->response = '0';
        $ticket->created_at = now();
        $ticket->updated_at = now();
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket created successfully.');
    }
}