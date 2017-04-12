<?php

namespace App\Http\Controllers;

use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'images')
            ->latest()->paginate(12);

        return view('products.index', [
            'products' => $products
        ]);
    }

    public function show(Product $product)
    {
        return $product;
    }
}
