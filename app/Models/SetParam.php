<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetParam extends Model
{
    use HasFactory;

    protected $table = 'set_param'; // Specify the table name if it's different from the default plural form.

    protected $primaryKey = 'condition_id'; // Custom primary key

    protected $fillable = [
        'threshold_amount',
        'schedule',
        'commission_rate',
    ];

    protected $casts = [
        'threshold_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public $timestamps = false; 
}
