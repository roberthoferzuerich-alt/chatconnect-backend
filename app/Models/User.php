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

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_seen_at' => 'datetime',
        'is_online' => 'boolean',
        'settings' => 'array',
    ];

    public function resolveCurrentAvatarPath(): ?string
    {
        $avatar = $this->attributes['avatar'] ?? null;
        $avatarPath = $this->attributes['avatar_path'] ?? null;

        if ($avatar && $avatarPath && $avatar !== $avatarPath) {
            $fileA = storage_path('app/public/' . ltrim($avatar, '/'));
            $fileB = storage_path('app/public/' . ltrim($avatarPath, '/'));
            $existsA = is_file($fileA);
            $existsB = is_file($fileB);

            if ($existsA && $existsB) {
                return (@filemtime($fileA) >= @filemtime($fileB)) ? $avatar : $avatarPath;
            }
            if ($existsA) {
                return $avatar;
            }
            if ($existsB) {
                return $avatarPath;
            }
        }

        return $avatar ?: ($avatarPath ?: null);
    }

    public function getAvatarAttribute($value)
    {
        return $this->resolveCurrentAvatarPath();
    }

    public function getAvatarPathAttribute($value)
    {
        return $this->resolveCurrentAvatarPath();
    }

    public function getAvatarUrlAttribute()
    {
        $path = $this->resolveCurrentAvatarPath();
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
        $wallpaper = null;
        $settings = $this->settings;
        if (is_string($settings)) {
            $decoded = json_decode($settings, true);
            if (is_array($decoded)) {
                $wallpaper = $decoded['wallpaper'] ?? null;
            }
        } elseif (is_array($settings)) {
            $wallpaper = $settings['wallpaper'] ?? null;
        }

        if (!$wallpaper && !empty($this->attributes['wallpaper'])) {
            $wallpaper = $this->attributes['wallpaper'];
        }

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
