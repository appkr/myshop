<?php

namespace App\Contracts;

use App\Buyable;

interface Cart
{
    public function getCartId();
    public function items();
    public function add(Buyable $buyable, int $quantity = 1);
    public function update(Buyable $buyable, int $quantity = null);
    public function remove(Buyable $buyable);
    public function reset();
    public function total();
    public function findItem(Buyable $buyable);
}