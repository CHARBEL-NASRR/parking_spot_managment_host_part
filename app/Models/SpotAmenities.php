<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpotAmenities extends Model
{
    protected $table = 'spot_amenities'; // Ensure the table name matches the migration
    protected $primaryKey = 'amenity_id';  // Custom primary key
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'spot_id',
        'is_covered',
        'is_gated',
        'has_security',
        'has_ev_charging',
        'is_handicap_accessible',
        'has_lighting',
        'has_cctv'
    ];

    protected $casts = [
        'is_covered' => 'boolean',
        'is_gated' => 'boolean',
        'has_security' => 'boolean',
        'has_ev_charging' => 'boolean',
        'is_handicap_accessible' => 'boolean',
        'has_lighting' => 'boolean',
        'has_cctv' => 'boolean',
    ];

    public function parkingSpot(): BelongsTo
    {
        return $this->belongsTo(ParkingSpot::class, 'spot_id');
    }
}