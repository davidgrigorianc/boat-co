<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['country', 'city', 'latitude', 'longitude'];

    public function boats(): HasMany
    {
        return $this->hasMany(Boat::class);
    }
}
