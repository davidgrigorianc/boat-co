<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoatImage extends Model
{
    use HasFactory;

    protected $fillable = ['boat_id', 'is_primary', 'path'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($image) {
            if ($image->is_primary) {
                self::where('boat_id', $image->boat_id)->update(['is_primary' => false]);
            }
        });
    }

    public function boat(): BelongsTo
    {
        return $this->belongsTo(Boat::class);
    }
}
