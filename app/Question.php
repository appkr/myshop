<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Question
 *
 * @property int $id
 * @property int $questionable_id
 * @property string $questionable_type
 * @property int $product_id 상품 ID
 * @property int $parent_id 질문 쓰레드 부모
 * @property string $type
 * @property string $content 질문 또는 답변 본문
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $children
 * @property-read \App\Question $parent
 * @property-read \App\Product $product
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $questionable
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereQuestionableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereQuestionableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Question extends Model
{
    /* RELATIONSHIPS */

    public function questionable()
    {
        return $this->morphTo();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function children()
    {
        return $this->hasMany(Question::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Question::class, 'parent_id');
    }
}
