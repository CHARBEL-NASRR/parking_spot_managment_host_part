<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    protected $table = 'wallets';  // Correct table name
    protected $primaryKey = 'wallet_id'; // Custom primary key
    public $incrementing = true;  // Ensures wallet_id is auto-incrementing
    protected $keyType = 'int';  // Type of the primary key
    public $timestamps = true; // Enable timestamps (to use created_at and updated_at)

    // Fields that can be mass-assigned
    protected $fillable = [
        'user_id',
        'balance',
        'last_updated'
    ];

    // Cast attributes to appropriate data types
    protected $casts = [
        'balance' => 'decimal:2',
        'last_updated' => 'datetime'
    ];

    /**
     * Get the user associated with the wallet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
