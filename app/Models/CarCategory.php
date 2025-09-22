<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CarCategory extends Model
{
     use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'is_favorite',
        'number_of_cars',
        'seats',
        'daily_rate',
        'picture'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_favorite' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'category_id');
    }
}
