<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Announcement
 *
 * @property int $id
 * @property int $member_id 공지 작성자
 * @property string $content 공지 본문
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Member $notifier
 * @method static \Illuminate\Database\Query\Builder|\App\Announcement whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Announcement whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Announcement whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Announcement whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Announcement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Announcement extends Model
{
    /* RELATIONSHIPS */

    public function notifier()
    {
        return $this->belongsTo(Member::class);
    }
}
