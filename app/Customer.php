<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Customer
 *
 * @property int $id
 * @property string $name 사용자 이름
 * @property string $email 이메일 (로그인에 사용됨)
 * @property string $password 비밀번호
 * @property string $remember_token 로그인 기억 토큰
 * @property string $zipcode 우편번호
 * @property string $address 주소
 * @property string $phone_number 전화번호
 * @property string $date_of_birth 생년월일
 * @property string $gender 성별
 * @property string $profile 자기 소개
 * @property int $points 포인트
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Address[] $addresses
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $questions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Review[] $reviews
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Wishlist[] $wishlists
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereDateOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer wherePhoneNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer wherePoints($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereProfile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereZipcode($value)
 * @mixin \Eloquent
 */
class Customer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'customer';

    protected $fillable = [
        'name',
        'email',
        'password',
        'zipcode',
        'address',
        'phone_number',
        'date_of_birth',
        'gender',
        'profile',
    ];

    /* RELATIONSHIPS */

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function questions()
    {
        return $this->morphMany(Question::class, 'questionable');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
