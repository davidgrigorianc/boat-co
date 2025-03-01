<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\BoatFactory;
use Illuminate\Support\Facades\Log;

class Boat extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_new', 'description', 'boat_type', 'fuel_type',
        'engine_number', 'price', 'year', 'length', 'boat_model_id', 'location_id'
    ];

    public function boat_model()
    {
        return $this->belongsTo(BoatModel::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function images()
    {
        return $this->hasMany(BoatImage::class);
    }

    public function mainImage()
    {
        return $this->hasOne(BoatImage::class)->where('is_primary', true);
    }

    public function engines()
    {
        return $this->hasMany(Engine::class);
    }


    // filter and sort scopes
    public function scopeFilterByCategory(Builder $query, $category)
    {
        if (!empty($category) && $category !== 'all') {
            $query->where('boat_type', $category);
        }
        return $query;
    }

    public function scopeFilterByCondition(Builder $query, $condition)
    {
        if (!empty($condition) && $condition !== 'all') {
            $isNew = $condition === 'new' ? 1 : 0;
            $query->where('is_new', $isNew);
        }
        return $query;
    }

    public function scopeFilterByManufacturer(Builder $query, $manufacturer_id)
    {
        if (!empty($manufacturer_id)) {
            $query->whereHas('boat_model.manufacturer', function (Builder $query) use ($manufacturer_id) {
                $query->where('id', $manufacturer_id);
            });
        }
        return $query;
    }

    public function scopeFilterByBoatModel(Builder $query, $model_id)
    {
        if (!empty($model_id)) {
            $query->where('boat_model_id', $model_id);
        }
        return $query;
    }

    public function scopeFilterByLength(Builder $query, array $length)
    {
        if (count($length) === 2) {
            $query->whereBetween('length', $length);
        }
        return $query;
    }

    public function scopeFilterByYear(Builder $query, array $year)
    {
        if (count($year) === 2) {
            $query->whereBetween('year', $year);
        }
        return $query;
    }

    public function scopeFilterByPrice(Builder $query, array $price)
    {
        if (count($price) === 2) {
            $query->whereBetween('price', $price);
        }
        return $query;
    }

    public function scopeFilterByStatus(Builder $query, $status = 'available')
    {
        return  $query->where('status', $status);
    }

    public function scopeOrderByColumn(Builder $query, $column, $direction = 'asc')
    {
        if (in_array($column, ['price', 'length', 'year', 'created_at'])) {
            $query->orderBy($column, $direction);
        } elseif ($column === 'manufacturer') {
            $query->orderByManufacturer($direction);
        }
        return $query;
    }

    public function scopeOrderByManufacturer(Builder $query, $direction = 'asc')
    {
        return $query->join('boat_models', 'boats.boat_model_id', '=', 'boat_models.id')
            ->join('manufacturers', 'boat_models.manufacturer_id', '=', 'manufacturers.id')
            ->orderBy('manufacturers.name', $direction);
    }

}
