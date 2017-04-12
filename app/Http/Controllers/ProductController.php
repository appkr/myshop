<?php

namespace App\Http\Controllers;

use App\Product;
use App\Queries\ProductQuery;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, ProductQuery $query)
    {
        $products = $query->get($request);

        return view('products.index', [
            'products' => $products
        ]);
    }

    public function show(Product $product)
    {
        return $product;
    }
}
