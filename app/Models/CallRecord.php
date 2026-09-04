<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'caller_id',
        'receiver_id',
        'type',
        'status',
        'started_at',
        'duration_seconds',
    ];

    protected $casts = [
        'started_at' => 'datetime',
    ];

    public function caller()
    {
        return $this->belongsTo(User::class, 'caller_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
