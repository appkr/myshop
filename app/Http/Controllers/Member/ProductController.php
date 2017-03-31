<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Image;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:members');
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $member = $request->user();

        /** @var Product $product */
        $product = $member->products()->create([
            'category_id' => $request->getCategoryId(),
            'title' => $request->getTitle(),
            'sub_title' => $request->getSubTitle(),
            'price' => $request->getPrice(),
            'options' => $request->getOptions(),
            'description' => $request->getDescription(),
        ]);

        $request->getImages()->each(function (Image $image) use ($product) {
            // 항상 belongsTo 쪽에서 associate()를 호출합니다.
            $image->product()->associate($product)->save();
        });

        return redirect(route('products.index'));
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
