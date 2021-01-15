<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Joselfonseca\LaravelTactician\CommandBusInterface;

class CommandsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $commandsHandlers = [
        'Vera\Rover\App\Command\Rover\Sequence\RoverSequenceCommand' => 'Vera\Rover\App\Command\Rover\Sequence\RoverSequenceHandler'
    ];

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Register all the commands and handlers
     */
    public function boot()
    {
        $this->app->singleton(CommandBusInterface::class, function () {
            $bus = $this->app->make(CommandBusInterface::class);
            foreach($this->commandsHandlers as $command => $handler) {
                $bus->addHandler($command, $handler);
            }
            return $bus;
        });
    }

}
