<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
    ];

    /**
     * Filter products by category and price range.
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        // Category
        if ($category = $filters['category'] ?? null) {
            $query->where('category', $category);
        }

        // Minimum price
        if ($minPrice = $filters['min_price'] ?? null) {
            $query->where('price', '>=', $minPrice);
        }

        // Maximum price
        if ($maxPrice = $filters['max_price'] ?? null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }

    /**
     * Search products by name.
     */
    public function scopeSearch(Builder $query, ?string $search)
    {
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query;
    }

    /**
     * Sort products dynamically.
     */
    public function scopeSort(Builder $query, ?string $sort)
    {
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;

            case 'price_low':
                $query->orderBy('price', 'asc');
                break;

            case 'price_high':
                $query->orderBy('price', 'desc');
                break;

            case 'name_az':
                $query->orderBy('name', 'asc');
                break;

            case 'name_za':
                $query->orderBy('name', 'desc');
                break;

            case 'latest':
            default:
                $query->latest();
                break;
        }

        return $query;
    }
}