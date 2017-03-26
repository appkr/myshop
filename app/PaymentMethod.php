<?php

namespace App;

use App\Support\BaseEnum;

/**
 * Class PaymentMethod
 * @package App
 */
final class PaymentMethod extends BaseEnum
{
    const CARD = 'CARD';
    const PAYPAL = 'PAYPAL';
}
