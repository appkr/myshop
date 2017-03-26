<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Review
 *
 * @property int $id
 * @property int $customer_id 리뷰어
 * @property int $order_id 주문 번호
 * @property string $content 리뷰 본문
 * @property bool $rating 평점
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Order $order
 * @property-read \App\Customer $reviewer
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Review extends Model
{
    /* RELATIONSHIPS */

    public function reviewer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
