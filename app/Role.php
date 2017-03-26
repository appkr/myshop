<?php

namespace App;

use App\Support\BaseEnum;

/**
 * Class Role
 * @package App
 */
final class Role extends BaseEnum
{
    const BASE = 'BASE';
    const MANAGER = 'MANAGER';
    const ADMIN = 'ADMIN';
}
