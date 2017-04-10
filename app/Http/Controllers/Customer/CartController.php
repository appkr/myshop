<?php

namespace App\Http\Controllers\Customer;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\RemoveCartItemRequest;
use App\Http\Requests\StoreCartRequest;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customers');
    }

    public function index(Cart $cart)
    {
        return view('carts.index', [
            'cart' => $cart
        ]);
    }

    public function store(StoreCartRequest $request, Cart $cart)
    {
        $cart->add($request->getProduct(), 1);

        return $cart->items()->toJson();
        return response()->json(null, 204);
    }

    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $cart->update($request->getProduct(), $request->getQuantity());

        return response()->json(null, 204);
    }

    public function destroy(RemoveCartItemRequest $request, Cart $cart)
    {
        $cart->remove($request->getProduct());

        return response()->json(null, 204);
    }

    public function reset(Cart $cart)
    {
        $cart->reset();

        return response()->json(null, 204);
    }
}
