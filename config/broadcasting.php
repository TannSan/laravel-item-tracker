<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |

PUSHER_APP_ID=475130
PUSHER_APP_KEY=b08d374d9d2bed6f5664
PUSHER_APP_SECRET=a44d49fb5db3004a48be
PUSHER_APP_CLUSTER=eu
    */

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => 'b08d374d9d2bed6f5664',
            'secret' => 'a44d49fb5db3004a48be',
            'app_id' => '475130',
            'options' => [
                'cluster' => 'eu',
                'encrypted' => true,
            ],
        ],
/*
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true,
            ],
        ],
*/
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
