<?php

return [

    // 'defaults' => [
    //     'guard' => 'web', // default bisa diganti ke 'pegawai' jika perlu
    //     'passwords' => 'users',
    // ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [
        // 'web' => [
        //     'driver' => 'session',
        //     'provider' => 'users',
        // ],

        'pegawai' => [
            'driver' => 'session',
            'provider' => 'pegawai',
        ],

        'pembeli' => [
            'driver' => 'session',
            'provider' => 'pembeli',
        ],

        'penitip' => [
            'driver' => 'session',
            'provider' => 'penitip',
        ],

        'organisasi' => [
            'driver' => 'session',
            'provider' => 'organisasi',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        // 'users' => [
        //     'driver' => 'eloquent',
        //     'model' => App\Models\User::class,
        // ],

        'pegawai' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pegawai::class,
        ],

        'penitip' => [
            'driver' => 'eloquent',
            'model' => App\Models\Penitip::class,
        ],

        'pembeli' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pembeli::class,
        ],

        'organisasi' => [
            'driver' => 'eloquent',
            'model' => App\Models\Organisasi::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Settings
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        // 'users' => [
        //     'provider' => 'users',
        //     'table' => 'password_reset_tokens',
        //     'expire' => 60,
        //     'throttle' => 60,
        // ],

        'pegawai' => [
            'provider' => 'pegawai',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],  

        'penitip' => [
            'provider' => 'penitip',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],  

        'pembeli' => [
            'provider' => 'pembeli',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'organisasi' => [
            'provider' => 'organisasi',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];