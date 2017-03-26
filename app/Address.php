<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Address
 *
 * @property int $id
 * @property int $customer_id 주소 소유자
 * @property string $zipcode 우편번호
 * @property string $address 주소
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Delivery[] $deliveries
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereZipcode($value)
 * @mixin \Eloquent
 */
class Address extends Model
{
    /* RELATIONSHIPS */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
