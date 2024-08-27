<?php

namespace App\Providers;

use App\Events\ProjectUpdated;
use App\Listeners\SendProjectUpdateNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProjectUpdated::class => [
            SendProjectUpdateNotification::class,
        ],
    ];
}
