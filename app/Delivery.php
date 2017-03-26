<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Delivery
 *
 * @property int $id
 * @property int $order_id 주문
 * @property int $address_id 배송 목적지
 * @property float $weight 무게
 * @property string $package_type
 * @property string $status 배송상태
 * @property string $agent 택배사
 * @property int $payable_delivery_fee 정산할 배송비
 * @property string $message 배송 메시지
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Address $address
 * @property-read \App\Order $order
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery whereAgent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery wherePackageType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery wherePayableDeliveryFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery whereWeight($value)
 * @mixin \Eloquent
 */
class Delivery extends Model
{
    /* RELATIONSHIPS */

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
