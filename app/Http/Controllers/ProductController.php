<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    /**
     * Display products with:
     * Search
     * Filtering
     * Sorting
     * Pagination
     * Statistics
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $baseQuery = Product::filter(
            $request->only([
                'category',
                'min_price',
                'max_price',
            ])
        )->search($request->input('search'));

        /*
        |--------------------------------------------------------------------------
        | Statistics
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
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully!');
    }

    /**
     * Update an existing product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Delete a single product.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Bulk delete products.
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        Product::whereIn('id', $validated['product_ids'])->delete();

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                count($validated['product_ids']) . ' product(s) deleted successfully!'
            );
    }

    /**
     * Export filtered products as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $query = Product::filter(
            $request->only([
                'category',
                'min_price',
                'max_price',
            ])
        )->search($request->input('search'));

        $products = $query
            ->sort($request->input('sort'))
            ->get();

        $fileName = 'products-' . now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function () use ($products) {

            $handle = fopen('php://output', 'w');

            /*
            |--------------------------------------------------------------------------
            | CSV Header
            |--------------------------------------------------------------------------
            */

            fputcsv($handle, [
                'ID',
                'Product Name',
                'Category',
                'Price',
                'Created At',
            ]);

            /*
            |--------------------------------------------------------------------------
            | CSV Rows
            |--------------------------------------------------------------------------
            */

            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->id,
                    $product->name,
                    $product->category,
                    $product->price,
                    $product->created_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);

        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }
}