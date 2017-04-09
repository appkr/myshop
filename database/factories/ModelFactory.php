<?php

use App\Address;
use App\AgentType;
use App\Announcement;
use App\Category;
use App\Customer;
use App\Delivery;
use App\DeliveryStatus;
use App\Gender;
use App\Member;
use App\Order;
use App\PackageType;
use App\PaymentMethod;
use App\Price;
use App\Product;
use App\Question;
use App\QuestionType;
use App\Review;
use App\Role;
use App\Support\KoreanLoremProvider;
use App\Wishlist;
use Faker\Factory;

/** @var \Faker\Generator $faker */
$faker = Factory::create('ko_KR');
$koreanProvider = new KoreanLoremProvider($faker);
$faker->addProvider($koreanProvider);

$factory->define(Member::class, function () use ($faker) {
    $roles = Role::toArray();

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'remember_token' => str_random(10),
        'role' => $faker->randomElement($roles),
    ];
});

$factory->define(Customer::class, function () use ($faker) {
    $genders = Gender::toArray();

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'remember_token' => str_random(10),
        'zipcode' => $faker->randomNumber(5),
        'address' => $faker->address,
        'phone_number' => $faker->phoneNumber,
        'date_of_birth' => $faker->dateTimeBetween('-50years', '-10years'),
        'gender' => $faker->randomElement($genders),
    ];
});

$factory->define(Product::class, function () use ($faker) {
    $lastCategoryId = Category::count();
    $category = Category::find(rand(1, $lastCategoryId));

    return [
        'category_id' => $category->id,
        'title' => $category->name . rand(1, 100),
        'sub_title' => $faker->korSentence(),
        'stock' => rand(10, 100),
        'price' => rand(250000, 3000000),
        'options' => collect([
            [
                str_random(10) => $faker->korParagraph()
            ]
        ]),
        'description' => $faker->korParagraph(),
    ];
});

$factory->define(Order::class, function () use ($faker) {
    $lastProductId = Product::count();
    $product = Product::find(rand(1, $lastProductId));

    $unit = rand(1, 3);
    $billableAmount = $product->price * $unit;
    $billableDeliveryFee = 3000;

    return [
        'billable_amount' => $billableAmount,
        'billable_delivery_fee' => $billableDeliveryFee,
        'payment_method' => $faker->randomElement(PaymentMethod::toArray()),
        'checkout_at' => $faker->dateTimeBetween('-1 years', 'yesterday'),
        'message' => $faker->korSentence(),
    ];
});

$factory->define(Address::class, function () use ($faker) {
    return [
        'zipcode' => rand(10000, 99999),
        'address' => $faker->address,
    ];
});

$factory->define(Delivery::class, function () use ($faker) {
    $address = Address::get()->shuffle()->first();

    return [
        'address_id' => $address->id,
        'weight' => rand(1, 10),
        'package_type' => $faker->randomElement(PackageType::toArray()),
        'status' => $faker->randomElement(DeliveryStatus::toArray()),
        'agent' => $faker->randomElement(AgentType::toArray()),
        'payable_delivery_fee' => 3000,
    ];
});

$factory->define(Review::class, function () use ($faker) {
    $order = Order::get()->shuffle()->first();

    return [
        'order_id' => $order->id,
        'content' => $faker->korParagraph(),
        'rating' => rand(1, 5),
    ];
});

$factory->define(Question::class, function () use ($faker) {
    $product = Product::get()->shuffle()->first();

    return [
        'product_id' => $product->id,
        'parent_id' => null,
        'type' => $faker->randomElement(QuestionType::toArray()),
        'content' => $faker->korParagraph(),
    ];
});

$factory->define(Wishlist::class, function () use ($faker) {
    $product = Product::get()->shuffle()->first();

    return [
        'product_id' => $product->id,
    ];
});

$factory->define(Announcement::class, function () use ($faker) {
    return [
        'content' => $faker->korParagraph(),
    ];
});
