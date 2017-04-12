<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Order
 *
 * @property int $id
 * @property int $customer_id 주문자
 * @property int $billable_amount 전체 구매 금액
 * @property int $billable_delivery_fee 청구할 배송비
 * @property string $payment_method 결제 방법
 * @property \Carbon\Carbon $checkout_at 결제 시각
 * @property string $message 주문 메시지
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Customer $customer
 * @property-read \App\Delivery $delivery
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Review[] $reviews
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereBillableAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereBillableDeliveryFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCheckoutAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder thisWeek($query)
 */
class Order extends Model
{
    protected $fillable = [
        'billable_amount',
        'billable_delivery_fee',
        'payment_method',
        'checkout_at',
    ];

    protected $dates = [
        'checkout_at',
    ];

    /* RELATIONSHIPS */

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withTimestamps()->withPivot('quantity');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /* QUERY SCOPE */

    public function scopeThisWeek(Builder $query)
    {
        return $query->where(
            'created_at', '>', Carbon::now()->subWeek()
        );
    }
}
