<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoatModel extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'manufacturer_id'];


    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function boats()
    {
        return $this->hasMany(Boat::class);
    }
}
