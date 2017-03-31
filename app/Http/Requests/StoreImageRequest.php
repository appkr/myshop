<?php

namespace App\Http\Requests;

class StoreImageRequest extends ShopRequest
{
    public function rules()
    {
        return [
            'image' => 'required',
        ];
    }

    public function getImage()
    {
        return collect($this->file('image'));
    }
}
