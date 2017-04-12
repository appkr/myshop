<?php

namespace App\Queries;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ProductQuery
{
    public function get(Request $request)
    {
        $builder = Product::with('category', 'images');

        if ($request->has('category')) {
            $builder = $builder->whereCategoryId(
                Category::whereName($request->input('category'))->first()->id
            );
        }

        if ($request->has('search')) {
            $builder = $builder->where(
                'title', 'like', '%'.$request->input('search').'%'
            );
        }

        return $builder->latest()->paginate(12);
    }
}