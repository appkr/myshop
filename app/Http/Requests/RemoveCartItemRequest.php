<?php

namespace App\Http\Requests;

use App\Product;

class RemoveCartItemRequest extends ShopRequest
{
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
        ];
    }

    public function getProduct()
    {
        return Product::findOrFail($this->input('product_id'));
    }
}
