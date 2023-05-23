<?php

namespace Snappshop\Actor\Providers;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use Snappshop\Actor\Actor;
use Snappshop\Actor\Facades\Actor as ActorFacade;

/**
 * @method actor(string $action, $hasType, $hasTimestamp, $indexName, $shouldIndex)
 */
class ActorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../resources/config/actor.php' => config_path('actor.php')
        ], 'actor-config');

        ActorFacade::defineMacros();
    }

    public function register(): void
    {
        $this->app->bind('actor', function () {
            return new Actor();
        });
    }
}