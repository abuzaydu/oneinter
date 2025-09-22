<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'car_id',
        'category_id',
        'driver_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'pickup_location',
        'destination',
        'region',
        'color',
        'organization',
        'id_type',
        'id_number',
        'pickup_date',
        'return_date',
        'special_requests',
        'total_amount',
        'status',
        'reference_number'
    ];

    protected $casts = [
        'pickup_date' => 'datetime',
        'return_date' => 'datetime',
        'total_amount' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->reference_number)) {
                $booking->reference_number = self::generateUniqueReferenceNumber();
            }
        });
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function category()
    {
        return $this->belongsTo(CarCategory::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function calculateTotalAmount()
    {
        $days = $this->pickup_date->diffInDays($this->return_date);
        
        if ($this->car && $this->car->category) {
            return $this->car->category->daily_rate * $days;
        } elseif ($this->category) {
            return $this->category->daily_rate * $days;
        }
        
        return 0;
    }

    /**
     * Generate a unique reference number for the booking
     * Format: BK-YYYYMMDD-XXXX (e.g., BK-20250725-0001)
     */
    public static function generateUniqueReferenceNumber()
    {
        $date = now()->format('Ymd');
        $prefix = "BK-{$date}-";
        
        // Get the last booking number for today
        $lastBooking = self::where('reference_number', 'like', $prefix . '%')
                           ->orderBy('reference_number', 'desc')
                           ->first();
        
        if ($lastBooking) {
            // Extract the number part and increment
            $lastNumber = (int) substr($lastBooking->reference_number, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        // Format with leading zeros
        $referenceNumber = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        // Ensure uniqueness (in case of race conditions)
        while (self::where('reference_number', $referenceNumber)->exists()) {
            $nextNumber++;
            $referenceNumber = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }
        
        return $referenceNumber;
    }

    /**
     * Get available colors for a specific category
     */
    public static function getAvailableColors($categoryId)
    {
        return Car::where('category_id', $categoryId)
                  ->where('is_available', true)
                  ->whereNotNull('color')
                  ->distinct()
                  ->pluck('color')
                  ->filter()
                  ->values();
    }
}
