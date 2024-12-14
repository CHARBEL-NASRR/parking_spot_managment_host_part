<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'sender_wallet_id',
        'receiver_wallet_id',
        'booking_id',
        'transaction_type',
        'deducted_amount',
        'received_amount',
        'commission_amount',
        'ticket_id',
    ];

    public $timestamps = false; // Disable timestamps

    /**
     * Get the wallet associated with the sender.
     */
    public function senderWallet()
    {
        return $this->belongsTo(Wallet::class, 'sender_wallet_id');
    }

    /**
     * Get the wallet associated with the receiver.
     */
    public function receiverWallet()
    {
        return $this->belongsTo(Wallet::class, 'receiver_wallet_id');
    }

    /**
     * Get the booking associated with the transaction.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    /**
     * Get the ticket associated with the transaction.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
