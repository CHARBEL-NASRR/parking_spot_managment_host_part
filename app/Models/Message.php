<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender',
        'receiver',
        'message',
    ];

    
    public function sender()
    {
        return $this->belongsTo(HostDetail::class, 'sender', 'host_id');
    }

    public function receiver()
    {
        return $this->belongsTo(HostDetail::class, 'receiver', 'host_id');
    }
}
