<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function routeNotificationForMail()
    {
        return config('mail.admin_email');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            // Use direct public path for better accessibility
            return asset($this->profile_picture);
        }
        return asset('assets/images/user/avatar-1.jpg');
    }
}
