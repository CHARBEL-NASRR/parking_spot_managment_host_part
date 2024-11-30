<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Availability extends Model
{
    use HasFactory;
    protected $table = 'availability';  // Ensure the table name matches the migration
    protected $primaryKey = 'availability_id';
    public $timestamps = false;

    protected $fillable = [
        'spot_id',
        'start_time_availability',
        'end_time_availability',
        'day',
    ];



    public function parkingSpot(): BelongsTo
    {
        return $this->belongsTo(ParkingSpot::class, 'spot_id');
    }
}
