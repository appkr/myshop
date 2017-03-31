<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Image
 *
 * @property int $id
 * @property int $product_id 연결된 상품
 * @property string $filename 이미지 파일 이름
 * @property int $bytes 파일 크기 (바이트)
 * @property string $mime 마임 타입
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Product $product
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereBytes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereMime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Image extends Model
{
    protected $fillable = [
        'product_id',
        'filename',
        'bytes',
        'mime',
    ];

    protected $appends = [
        'url',
    ];

    /* RELATIONSHIPS */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /* ACCESSOR */

    public function getUrlAttribute()
    {
        return asset("storage/product_images/{$this->filename}");
    }
}
