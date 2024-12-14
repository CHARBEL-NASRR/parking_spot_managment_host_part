<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'guest_id',
        'spot_id',
        'start_time',
        'end_time',
        'status',
        'total_price',
    ];

    /**
     * Get the parking spot associated with the booking.
     */
    public function spot()
    {
        return $this->belongsTo(Spot::class, 'spot_id');
    }

    // Uncomment this method once the guest table is available
    // public function guest()
    // {
    //     return $this->belongsTo(User::class, 'guest_id', 'user_id');
    // }
}
