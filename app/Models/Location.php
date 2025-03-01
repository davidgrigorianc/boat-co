<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\LocationFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['country', 'city', 'latitude', 'longitude'];

    public function boats()
    {
        return $this->hasMany(Boat::class);
    }
}
