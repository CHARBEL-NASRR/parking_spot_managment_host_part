<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetParam extends Model
{
    use HasFactory;

    protected $table = 'set_param';

    protected $primaryKey = 'condition_id';

    protected $fillable = [
        'threshold_amount',
        'schedule',
        'commission_rate',
        'created_at',
    ];

    public $timestamps = false;
}