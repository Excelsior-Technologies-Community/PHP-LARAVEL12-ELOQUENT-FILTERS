<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $fillable = ['name', 'category', 'price'];

    // Filter scope banavavo
    public function scopeFilter(Builder $query, array $filters)
    {
        // Category filter
        if ($category = $filters['category'] ?? null) {
            $query->where('category', $category);
        }

        // Min Price filter
        if ($minPrice = $filters['min_price'] ?? null) {
            $query->where('price', '>=', $minPrice);
        }

        // Max Price filter
        if ($maxPrice = $filters['max_price'] ?? null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }
}
