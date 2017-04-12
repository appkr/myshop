<?php

namespace App;

use App\Contracts\Cart as CartContract;
use App\Exceptions\CartItemNotFoundException;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\Repository as CacheStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Cart implements CartContract
{
    const CART_DAY_TO_LIVE = 7;

    /** @var CacheStorage */
    private $storage;

    /** @var string */
    private $storageKey;

    /** @var Collection */
    private $instance;

    public function __construct(CacheStorage $cache, Request $request)
    {
        $this->storageKey = 'cart.' . $request->user('customers')->id;
        $this->storage = $cache;
        $this->initialize();
    }

    /**
     * 카트 ID를 조회합니다.
     *
     * @return string
     */
    public function getCartId()
    {
        return $this->storageKey;
    }

    /**
     * 카트에 담긴 내용을 조회합니다.
     *
     * @return Collection
     */
    public function items()
    {
        return $this->instance;
    }

    /**
     * 카트에 상품을 추가합니다.
     *
     * @param Buyable $buyable
     * @param int $quantity
     */
    public function add(Buyable $buyable, int $quantity = 1)
    {
        /** @var Buyable $found */
        $found = $this->findItem($buyable);

        if ($found) {
            $this->update($buyable, $found->quantity() + $quantity);
            return;
        }

        $buyable->setQuantity($quantity);
        $this->instance->push($buyable);
        $this->saveToStorage();
    }

    /**
     * 카트에 담긴 상품을 교체합니다.
     *
     * @param Buyable $buyable
     * @param int $quantity
     */
    public function update(Buyable $buyable, int $quantity = null)
    {
        if (! $quantity || $quantity <= 0) {
            return;
        }

        $this->rejectItem($buyable);
        $buyable->setQuantity($quantity);
        $this->instance->push($buyable);
        $this->saveToStorage();
    }

    /**
     * 카트에서 상품을 뺍니다.
     *
     * @param Buyable $buyable
     */
    public function remove(Buyable $buyable)
    {
        $this->rejectItem($buyable);
        $this->saveToStorage();
    }

    /**
     * 저장소에 저장된 카트를 비웁니다.
     */
    public function reset()
    {
        $this->storage->forget($this->storageKey);
    }

    /**
     * 총 구매 금액을 계산합니다.
     *
     * @return mixed
     */
    public function total()
    {
        return $this->instance->reduce(function ($carry = 0, Buyable $buyable) {
            return $carry + $buyable->subTotal();
        });
    }

    /**
     * 카트에 담긴 상품을 찾습니다.
     *
     * @param Buyable $buyable
     * @return Buyable|null
     */
    public function findItem(Buyable $buyable)
    {
        return $this->instance->filter(function (Buyable $oldItem) use ($buyable) {
            return $oldItem->isSameAs($buyable);
        })->first();
    }

    /**
     * 카트에서 상품을 뺍니다.
     *
     * @param $buyable
     */
    private function rejectItem(Buyable $buyable)
    {
        $found = $this->findItem($buyable);

        if (! $found) {
            throw new CartItemNotFoundException;
        }

        $this->instance = $this->instance->reject(function (Buyable $oldItem) use ($buyable) {
            return $oldItem->isSameAs($buyable);
        })->values();
    }

    /**
     * 저장소에 카트를 저장합니다.
     */
    private function saveToStorage()
    {
        $expireAt = Carbon::now()->addDay(self::CART_DAY_TO_LIVE);

        $this->storage->put(
            $this->storageKey, $this->instance, $expireAt
        );
    }

    /**
     * 저장소로부터 카트를 재생합니다. 없으면 메모리에 새 카트를 만듭니다.
     */
    private function initialize()
    {
        $this->instance = $this->storage->get($this->storageKey)
            ?: collect([]);
    }
}