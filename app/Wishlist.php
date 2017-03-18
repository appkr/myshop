<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Wishlist
 *
 * @property int $id
 * @property int $customer_id 잠재 구매자
 * @property int $product_id 상품 ID
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Customer $owner
 * @method static \Illuminate\Database\Query\Builder|\App\Wishlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Wishlist whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Wishlist whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Wishlist whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Wishlist whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Wishlist extends Model
{
    /* RELATIONSHIPS */

    public function owner()
    {
        return $this->belongsTo(Customer::class);
    }
}
