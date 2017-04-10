<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Product
 *
 * @property int $id
 * @property int $member_id 상품 등록 직원
 * @property int $category_id 연결된 카테고리
 * @property string $title 상품명
 * @property string $sub_title 상품명 보조
 * @property int $stock 재고 수량
 * @property int $price 상품 가격
 * @property string $options 상품 옵션
 * @property string $description 상품 설명
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Image[] $images
 * @property-read \App\Member $member
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $order
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereOptions($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereStock($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereSubTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model implements Buyable
{
    use CanBeBought;

    protected $fillable = [
        'category_id',
        'title',
        'sub_title',
        'price',
        'options',
        'description',
    ];

    protected $appends = [
        'quantity',
    ];

    /* Implement Contracts */

    public function price()
    {
        return $this->price;
    }

    /* RELATIONSHIPS */

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function order()
    {
        return $this->belongsToMany(Order::class)
            ->withTimestamps()->withPivot('quantity');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /* Accessors */

    public function getOptionsAttribute(string $value)
    {
        return collect(json_decode($value));
    }

    public function getQuantityAttribute()
    {
        return $this->quantity();
    }

    /* Mutators */

    public function setOptionsAttribute(Collection $options)
    {
        $this->attributes['options'] = $options->toJson();
    }
}
