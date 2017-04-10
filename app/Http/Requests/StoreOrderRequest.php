<?php

namespace App\Http\Requests;

use App\Cart;
use App\PaymentMethod;

class StoreOrderRequest extends ShopRequest
{
    public function rules()
    {
        return [];
    }
    
    public function getCart()
    {
        return app(Cart::class);
    }

    public function isCartEmpty()
    {
        return $this->getCart()->items()->isEmpty();
    }

    public function getCustomer()
    {
        return $this->user('customers');
    }

    public function getBillableAmount()
    {
        return $this->getCart()->total() ?: 0;
    }

    public function getPaymentMethod()
    {
        return $this->input(
            'payment_method',
            PaymentMethod::getInstance('CARD')
        );
    }

    public function getCartItemIds()
    {
        return $this->getCart()->items()->pluck('id');
    }
}
