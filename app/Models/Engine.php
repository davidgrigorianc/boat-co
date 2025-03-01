<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    use HasFactory;

    protected $fillable = [
        'boat_id', 'make', 'model', 'type', 'hours', 'power', 'fuel_type', 'drive_type'
    ];


    public function boat()
    {
        return $this->belongsTo(Boat::class);
    }
}
