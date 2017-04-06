<?php

return [

    'defaults' => [
        'guard' => 'customers',
        'passwords' => 'customers',
    ],

    'guards' => [
        'customers' => [
            'driver' => 'session',
            'provider' => 'customers',
        ],

        'customers-api' => [
            'driver' => 'token',
            'provider' => 'customers',
        ],

        'members' => [
            'driver' => 'session',
            'provider' => 'members',
        ],
    ],

    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model' => App\Customer::class,
        ],

        'members' => [
            'driver' => 'eloquent',
            'model' => App\Member::class,
        ],
    ],

    'passwords' => [
        'customers' => [
            'provider' => 'customers',
            'table' => 'password_resets',
            'expire' => 60,
        ],

        'members' => [
            'provider' => 'members',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

];
