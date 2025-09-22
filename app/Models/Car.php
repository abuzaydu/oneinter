<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category_id',
        'is_available',
        'plate_number',
        'color',
        'chassis_number'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'daily_rate' => 'decimal:2',
        'seats' => 'integer',
        'doors' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(CarCategory::class, 'category_id');
    }

    // Helper method to get available seat options
    public static function getSeatOptions()
    {
        return [2, 4, 6, 8];
    }

    // Helper method to get available door options
    public static function getDoorOptions()
    {
        return [2, 3, 4, 5];
    }
}
