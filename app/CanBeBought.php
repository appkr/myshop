<?php

namespace App;

use InvalidArgumentException;

trait CanBeBought
{
    /** @var int 수량 */
    private $quantity;

    /**
     * 수량을 설정합니다.
     *
     * @param int $quantity
     */
    public function setQuantity(int $quantity = 1)
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException;
        }

        $this->quantity = $quantity;
    }

    /**
     * 수량을 조회합니다.
     *
     * @return int|null
     */
    public function quantity()
    {
        return $this->quantity;
    }

    /**
     * 수량을 증가시킵니다.
     *
     * @param int $quantity
     */
    public function increase(int $quantity)
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException;
        }

        $this->quantity += $quantity;
    }

    /**
     * 수량을 감소시킵니다.
     *
     * @param int $quantity
     */
    public function decrease(int $quantity)
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException;
        }

        $this->quantity -= $quantity;
    }

    /**
     * 전체 금액을 조회합니다.
     *
     * @return int
     */
    public function subTotal()
    {
        return $this->price() * $this->quantity;
    }

    /**
     * 상품 ID를 조회합니다.
     *
     * @return mixed
     */
    public function buyableId()
    {
        return $this->getKey();
    }

    /**
     * 상품 가격을 조회합니다.
     *
     * @return int
     */
    public function price()
    {
        return 0;
    }

    /**
     * 두 상품을 비교합니다.
     *
     * @param Buyable $that
     * @return bool
     */
    public function isSameAs(Buyable $that)
    {
        return $this->getKey() == $that->getKey();
    }
}