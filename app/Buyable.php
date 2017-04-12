<?php

namespace App;

interface Buyable
{
    public function setQuantity(int $quantity = 1);
    public function quantity();
    public function increase(int $quantity);
    public function decrease(int $quantity);
    public function subTotal();
    public function buyableId();
    public function price();
    public function isSameAs(Buyable $that);
    public function getKey();
}