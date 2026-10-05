<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'avatar_path',
        'about',
        'last_seen_at',
        'is_online',
        'settings',
        'fcm_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'avatar_url',
        'wallpaper_url',
    ];

    public function getAvatarUrlAttribute()
    {
        $path = $this->avatar_path ?? $this->avatar;
        if (!$path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return '/storage/' . ltrim($path, '/');
    }

    public function getWallpaperUrlAttribute()
    {
        $settings = $this->settings ?? [];
        $wallpaper = $settings['wallpaper'] ?? null;
        if (!$wallpaper) {
            return null;
        }
        if (str_starts_with($wallpaper, 'http://') || str_starts_with($wallpaper, 'https://')) {
            return $wallpaper;
        }
        return '/storage/' . ltrim($wallpaper, '/');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen_at' => 'datetime',
            'is_online' => 'boolean',
            'settings' => 'array',
        ];
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function communities()
    {
        return $this->belongsToMany(Community::class)->withPivot('role')->withTimestamps();
    }
}
