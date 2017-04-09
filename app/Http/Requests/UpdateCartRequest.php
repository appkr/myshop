<?php

namespace App\Http\Requests;

use App\Product;

class UpdateCartRequest extends ShopRequest
{
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer'
        ];
    }

    public function getProduct()
    {
        return Product::findOrFail($this->input('product_id'));
    }

    public function getQuantity()
    {
        return (int) $this->input('quantity');
    }
}
