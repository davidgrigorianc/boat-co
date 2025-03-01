<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Boat extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_new', 'description', 'boat_type', 'fuel_type',
        'engine_number', 'price', 'year', 'length', 'boat_model_id', 'location_id'
    ];

    public function boat_model(): BelongsTo
    {
        return $this->belongsTo(BoatModel::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(BoatImage::class);
    }

    public function mainImage(): HasOne
    {
        return $this->hasOne(BoatImage::class)->where('is_primary', true);
    }

    public function engines(): HasMany
    {
        return $this->hasMany(Engine::class);
    }
}
