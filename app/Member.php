<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Member
 *
 * @property int $id
 * @property string $name 이름
 * @property string $email 이메일
 * @property string $password 비밀번호
 * @property string $remember_token 로그인 기억 토큰
 * @property string $role 역할
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Announcement[] $announcements
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $answers
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Member extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    /* RELATIONSHIPS */

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function answers()
    {
        return $this->morphMany(Question::class, 'questionable');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
}
