<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParkingSpot extends Model
{
    protected $table = 'parking_spots';  // Fixed table name to match the migration
    protected $primaryKey = 'spot_id';  // Custom primary key
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;  // Assuming you don't want timestamps (if you do, remove this line)

    protected $fillable = [
        'spot_id',
        'host_id', 
        'longitude',
        'latitude',
        'price_per_hour',
        'car_type',
        'title',
        'main_description',
        'overall_rating',
        'status',
        'verification_documents',
        'key_box'
    ];

    /**
     * The host (user) associated with the parking spot.
     */
    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');  // Ensure 'host_id' is referencing the correct user model
    }

    /**
     * The amenities associated with the parking spot.
     */
    public function amenities(): HasOne
    {
        return $this->hasOne(SpotAmenity::class, 'spot_id');
    }

    /**
     * The availabilities of the parking spot.
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class, 'spot_id');
    }

    /**
     * The images associated with the parking spot.
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'spot_id');
    }

    /**
     * The locations associated with the parking spot.
     */
    public function locations(): HasMany
    {
        return $this->hasMany(SpotLocation::class, 'spot_id');
    }
}
