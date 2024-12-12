<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\HostDetail;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        // Get the logged-in user's ID
        $userId = Auth::id();

        // Get the host associated with the logged-in user
        $host = HostDetail::where('user_id', $userId)->first();

        // If no host is found, return an error
        if (!$host) {
            return redirect()->back()->withErrors('You are not associated with any host.');
        }

        // Fetch messages related to the logged-in host (sent or received)
        $messages = Message::with(['sender', 'receiver'])
            ->where('sender', $host->host_id)
            ->orWhere('receiver', $host->host_id)
            ->orderBy('created_at', 'desc') // Optional: To sort messages by creation date
            ->get();

        // Get all hosts (excluding the logged-in host) for messaging
        $hosts = HostDetail::where('host_id', '!=', $host->host_id)->with('user')->get();

        // Return the view with the necessary data
        return view('dashboard.chat', compact('host', 'hosts', 'messages'));
    }

    public function send(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'receiver_id' => 'required|exists:host_details,host_id',
            'message' => 'required|string|max:1000',
        ]);

        // Get the logged-in user's host details
        $host = HostDetail::where('user_id', Auth::id())->first();

        if (!$host) {
            return redirect()->back()->withErrors('You are not associated with any host.');
        }

        $message = Message::create([
            'sender' => $host->host_id,
            'receiver' => $request->receiver_id,
            'message' => $request->message,
        ]);

    broadcast(new MessageSent($message))->toOthers();

        return back()->with('success', 'Message sent successfully!');
    }
}