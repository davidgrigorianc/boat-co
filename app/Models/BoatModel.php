<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoatModel extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'manufacturer_id'];

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function boats(): HasMany
    {
        return $this->hasMany(Boat::class);
    }
}
