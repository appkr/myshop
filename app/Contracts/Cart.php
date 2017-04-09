<?php

namespace App\Contracts;

use App\Buyable;
use Illuminate\Support\Collection;

interface Cart
{
    /**
     * @return string
     */
    public function getCartId();

    /**
     * @return Collection
     */
    public function items();

    /**
     * @param Buyable $buyable
     * @param int $quantity
     * @return void
     */
    public function add(Buyable $buyable, int $quantity = 1);

    /**
     * @param Buyable $buyable
     * @param int|null $quantity
     * @return void
     */
    public function update(Buyable $buyable, int $quantity = null);

    /**
     * @param Buyable $buyable
     * @return void
     */
    public function remove(Buyable $buyable);

    /**
     * @return void
     */
    public function reset();

    /**
     * @return int
     */
    public function total();

    /**
     * @param Buyable $buyable
     * @return Buyable|null
     */
    public function findItem(Buyable $buyable);
}