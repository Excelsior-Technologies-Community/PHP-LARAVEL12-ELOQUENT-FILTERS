<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display products with filtering, searching,
     * sorting, pagination and price statistics.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Product Query
        |--------------------------------------------------------------------------
        | Apply filters and search first.
        | The same query will be used for both:
        | 1. Product listing
        | 2. Product statistics
        |--------------------------------------------------------------------------
        */

        $baseQuery = Product::filter(
            $request->only([
                'category',
                'min_price',
                'max_price',
            ])
        )
            ->search($request->input('search'));

        /*
        |--------------------------------------------------------------------------
        | Product Price Statistics
        |--------------------------------------------------------------------------
        */

        $statistics = [
            'total_products' => (clone $baseQuery)->count(),

            'lowest_price' => (clone $baseQuery)->min('price'),

            'highest_price' => (clone $baseQuery)->max('price'),

            'average_price' => (clone $baseQuery)->avg('price'),

            'total_value' => (clone $baseQuery)->sum('price'),
        ];

        /*
        |--------------------------------------------------------------------------
        | Product Listing
        |--------------------------------------------------------------------------
        | Sorting and pagination are applied only to the product listing.
        |--------------------------------------------------------------------------
        */

        $products = (clone $baseQuery)
            ->sort($request->input('sort'))
            ->paginate(5)
            ->withQueryString();

        return view('products', compact(
            'products',
            'statistics'
        ));
    }

    /**
     * Store a new product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully!');
    }
}