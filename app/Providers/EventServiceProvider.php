<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\B2c\Repositories\Events\VerifyEmailEvent' => [
            'App\B2c\Repositories\Listeners\VerifyEmailEventListener',
        ],
    ];
}
