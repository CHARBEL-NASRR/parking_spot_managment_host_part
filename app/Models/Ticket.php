<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $primaryKey = 'ticket_id'; // Custom primary key
    public $incrementing = true; // Ensures ticket_id is auto-incrementing
    protected $keyType = 'int'; // Type of the primary key
    public $timestamps = true; // Enable timestamps (created_at and updated_at)

    // Fields that can be mass-assigned
    protected $fillable = [
        'user_id',
        'admin_id',
        'type',
        'title',
        'status',
        'description',
        'response',
    ];

    /**
     * Get the user associated with the ticket.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the admin associated with the ticket.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'user_id');
    }
}
