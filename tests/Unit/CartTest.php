<?php

namespace Tests\Unit;

use App\Buyable;
use App\Cart;
use App\Category;
use App\Customer;
use App\Exceptions\CartItemNotFoundException;
use App\Member;
use App\Product;
use Illuminate\Contracts\Cache\Repository as CacheStorage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Tests\TestCase;

class CartTest extends TestCase
{
    use DatabaseMigrations;

    /** @var Customer */
    protected $customer;

    /** @var Cart */
    protected $cart;

    /** @var Request */
    protected $request;

    /** @var CacheManager */
    protected $storage;

    public function setUp()
    {
        parent::setUp();

        $this->prepareCategory();
        $this->createCustomer();
        $this->createRequest();
        $this->createCartStorage();
        $this->createCart();
    }

    /** Helpers */

    private function prepareCategory()
    {
        collect([
            Category::COMPUTER,
            Category::MOBILE,
        ])->each(function ($category) {
            (new Category)->forceFill([
                'name' => $category,
            ])->save();
        });
    }

    private function createCustomer()
    {
        $this->customer = factory(Customer::class)->create();
    }

    private function createRequest()
    {
        $this->request = request()->setUserResolver(function () {
            return $this->customer;
        });
    }

    private function createCartStorage()
    {
        $this->storage = app(CacheStorage::class);
    }

    private function createCart()
    {
        $this->cart = new Cart($this->storage, $this->request);
    }

    private function getBuyable()
    {
        $member = factory(Member::class)->create();

        return factory(Product::class)->create([
            'member_id' => $member->getKey(),
            'price' => 100,
        ]);
    }

    /** Cart Tests */

    public function test_cart_can_be_instantiable()
    {
        $this->assertInstanceOf(Cart::class, $this->cart);
        $this->assertTrue($this->cart->items()->isEmpty());
    }

    public function test_customer_can_add_a_cart_item()
    {
        $buyable = $this->getBuyable();
        $this->cart->add($buyable, 1);
//        dd($this->cart->items());

        $this->assertCount(1, $this->cart->items());
    }

    public function test_customer_can_add_multiple_items()
    {
        $buyable = $this->getBuyable();
        $this->cart->add($buyable, 1);
        $buyable = $this->getBuyable();
        $this->cart->add($buyable, 1);
//        dd($this->cart->items());

        $this->assertCount(2, $this->cart->items());
    }

    public function test_falling_back_to_update_when_the_item_exists()
    {
        $buyable = $this->getBuyable();
        $this->cart->add($buyable, 1);

        $this->assertCount(1, $this->cart->items());

        $this->cart->add($buyable, 1);
        $this->assertEquals(2, $this->cart->findItem($buyable)->quantity());
    }

    public function test_customer_can_update_an_existing_cart_item()
    {
        $buyable = $this->getBuyable();
        $this->cart->add($buyable, 1);
        $this->cart->update($buyable, 2);
//        dd($this->cart->items());

        $this->assertCount(1, $this->cart->items());
        $this->assertEquals(2, $this->cart->findItem($buyable)->quantity());
    }

    public function test_cart_should_update_only_given_item_when_there_are_multiple_items()
    {
        $buyableA = $this->getBuyable();
        $this->cart->add($buyableA, 1);
        $buyableB = $this->getBuyable();
        $this->cart->add($buyableB, 1);

        $this->cart->update($buyableB, 2);
//        dd($this->cart->items());

        $this->assertEquals(1, $this->cart->findItem($buyableA)->quantity());
        $this->assertEquals(2, $this->cart->findItem($buyableB)->quantity());
    }

    public function test_customer_can_drop_an_item()
    {
        $buyable = $this->getBuyable();
        $this->cart->add($buyable, 1);

        $this->cart->remove($buyable);
//        dd($this->cart->items());

        $this->assertCount(0, $this->cart->items());
    }

    public function test_update_api_should_throw_exception_when_not_existing_item_is_given()
    {
        $this->expectException(CartItemNotFoundException::class);

        $buyableA = $this->getBuyable();
        $this->cart->add($buyableA, 1);

        $buyableB = $this->getBuyable();
        $this->cart->update($buyableB, 1);
    }

    public function test_cart_can_be_destroyable()
    {
        $buyable = $this->getBuyable();
        $this->cart->add($buyable, 1);
        $this->cart->reset();

        $this->assertEquals(null, $this->storage->get($this->cart->getCartId()));
    }

    public function test_cart_can_produce_total_price()
    {
        $buyableA = $this->getBuyable();
        $this->cart->add($buyableA, 1);
        $buyableB = $this->getBuyable();
        $this->cart->add($buyableB, 1);

//        dd($this->cart->items());

        $this->assertEquals(200, $this->cart->total());

        $this->cart->update($buyableB, 5);
        $this->assertEquals(600, $this->cart->total());
    }

    /** Buyable Tests */

    public function test_buyable_should_be_buyable_type()
    {
        /** @var Buyable $buyable */
        $buyable = $this->getBuyable();

        $this->assertInstanceOf(Buyable::class, $buyable);
    }

    public function test_buyable_knows_who_is_it()
    {
        /** @var Buyable $buyable */
        $buyable = $this->getBuyable();

        $this->assertEquals($buyable->id, $buyable->buyableId());
    }

    public function test_buyable_should_not_accept_negative_quantity()
    {
        $this->expectException(InvalidArgumentException::class);

        /** @var Buyable $buyable */
        $buyable = $this->getBuyable();

        $buyable->setQuantity(-1);
        $buyable->increase(-1);
        $buyable->decrease(-1);
    }

    public function test_buyable_can_increase_its_quantity()
    {
        /** @var Buyable $buyable */
        $buyable = $this->getBuyable();
        $buyable->increase(1);
//        dd($buyable);

        $this->assertEquals(1, $buyable->quantity());

        $buyable->increase(1);
        $this->assertEquals(2, $buyable->quantity());
    }

    public function test_buyable_can_decrease_its_quantity()
    {
        /** @var Buyable $buyable */
        $buyable = $this->getBuyable();
        $buyable->setQuantity(1);
        $buyable->decrease(1);

        $this->assertEquals(0, $buyable->quantity());
    }

    public function test_buyable_can_calculate_its_subtotal()
    {
        /** @var Buyable $buyable */
        $buyable = $this->getBuyable();
        $price = $buyable->price();

        $buyable->setQuantity(1);

        $this->assertEquals($price * 1, $buyable->subTotal());

        $buyable->setQuantity(2);

        $this->assertEquals($price * 2, $buyable->subTotal());
    }

    public function test_buyable_can_recognize_same_id()
    {
        /** @var Buyable $buyable */
        $buyable = $this->getBuyable();

        $this->assertTrue($buyable->isSameAs($buyable));
    }
}