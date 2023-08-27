<?php

namespace Modules\Plan\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Jetstream\Events\TeamCreated;
use Modules\Plan\Listeners\CreateTeamPlans;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TeamCreated::class => [
            CreateTeamPlans::class
        ]
    ];
}