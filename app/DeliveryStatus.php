<?php

namespace App;

use App\Support\BaseEnum;

/**
 * Class DeliveryStatus
 * @package App
 */
final class DeliveryStatus extends BaseEnum
{
    const SUBMITTED = 'SUBMITTED';
    const PICKED = 'PICKED';
    const DELIVERED = 'DELIVERED';
}
