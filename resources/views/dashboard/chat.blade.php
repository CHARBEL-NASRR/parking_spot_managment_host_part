@extends('layouts.app')

@section('title', 'Messages')

@section('content')
    <div class="messaging-container">
        <!-- Left Side: List of Hosts -->
        <div class="hosts-list">
            <h1>Other Hosts</h1>
            @foreach ($hosts as $otherHost)
                <div class="host-item">
                    <p><strong>Host ID:</strong> {{ $otherHost->host_id }}</p>
                    <p><strong>User Name:</strong> {{ $otherHost->user->name }}</p>
                    <a href="{{ route('messages.index', ['hostId' => $otherHost->host_id]) }}" class="chat-link">Start Chat</a>
                </div>
            @endforeach
        </div>

        <!-- Right Side: Chat Window -->
        <div class="chat-window">
            <h1>Your Chat</h1>
            <div class="chat-box" id="chat-box">
                <!-- Display Messages -->
                @foreach ($messages as $message)
                    <div class="message" id="message-{{ $message->id }}">
                        <strong>From Host {{ $message->sender }}:</strong>
                        <span>{{ $message->message }}</span>
                        <em>(to Host {{ $message->receiver }})</em>
                    </div>
                @endforeach
            </div>

            <!-- Send Message Form -->
            <form id="message-form">
                @csrf
                <div class="form-group">
                    <label for="receiver_id">Select Host:</label>
                    <select name="receiver_id" id="receiver_id" required>
                        @foreach ($hosts as $otherHost)
                            <option value="{{ $otherHost->host_id }}">Host ID: {{ $otherHost->host_id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea name="message" id="message" rows="3" required></textarea>
                </div>

                <button type="submit" class="send-button">Send</button>
            </form>
        </div>
    </div>

    <!-- Styles -->
    <style>
        .messaging-container {
            display: flex;
            justify-content: space-between;
            margin: 20px;
        }

        .hosts-list {
            width: 30%;
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .host-item {
            margin-bottom: 15px;
        }

        .chat-link {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .chat-window {
            width: 65%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: 500px;
            display: flex;
            flex-direction: column;
        }

        .chat-box {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            height: 300px;
        }

        .message {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #e1f5fe;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .send-button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .send-button:hover {
            background-color: #0056b3;
        }
    </style>

    <!-- Include Pusher JavaScript for real-time updates -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>
        // Enable Pusher logging - don't include this in production
        Pusher.logToConsole = true;

        // Initialize Pusher
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        // Subscribe to the channel for the current chat
        var channel = pusher.subscribe('chat.{{ $host->host_id }}'); // Listening to the chat of the current host

        channel.bind('App\\Events\\MessageSent', function(data) {
            var messageContainer = document.getElementById('chat-box');
            var messageHTML = `
                <div class="message">
                    <strong>From Host ${data.sender}:</strong> 
                    <span>${data.message}</span>
                    <em>(to Host ${data.receiver})</em>
                </div>`;
            messageContainer.innerHTML += messageHTML;
            messageContainer.scrollTop = messageContainer.scrollHeight; // Scroll to bottom
        });

        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();

            var receiverId = document.getElementById('receiver_id').value;
            var message = document.getElementById('message').value;

            fetch('{{ route('messages.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ receiver_id: receiverId, message: message })
            })
            .then(response => response.json())
            .then(data => {
                // Clear the message input field
                document.getElementById('message').value = '';
            })
            .catch(error => console.error('Error sending message:', error));
        });
    </script>
@endsection
