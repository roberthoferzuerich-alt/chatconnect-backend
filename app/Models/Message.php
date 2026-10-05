<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'image_path',
        'audio_path',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    protected $appends = ['image_url', 'audio_url'];

    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }
        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }
        return '/storage/' . ltrim($this->image_path, '/');
    }

    public function getAudioUrlAttribute()
    {
        if (!$this->audio_path) {
            return null;
        }
        if (str_starts_with($this->audio_path, 'http://') || str_starts_with($this->audio_path, 'https://')) {
            return $this->audio_path;
        }
        return '/storage/' . ltrim($this->audio_path, '/');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function reactions()
    {
        return $this->hasMany(MessageReaction::class);
    }
}
