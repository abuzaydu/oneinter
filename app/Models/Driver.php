<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'is_active',
        'is_available'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_available' => 'boolean'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
