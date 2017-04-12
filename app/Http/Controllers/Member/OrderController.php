<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:members');
    }

    public function index()
    {
        $orders = Order::with('products', 'customer', 'delivery')
            ->withCount('products')
            ->thisWeek()
            ->inRandomOrder()
            ->paginate(10);

        return view('orders.index', [
            'orders' => $orders
        ]);
    }
}
