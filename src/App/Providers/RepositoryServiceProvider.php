<?php

namespace App\Providers;

use Illuminate\Cache\Repository;
use Illuminate\Support\ServiceProvider;
use Vera\Rover\Domain\Rover\Model\RoverRepository;
use Vera\Rover\Infrastructure\Persistence\MemoryRoverRepository;

class RepositoryServiceProvider extends ServiceProvider
{


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RoverRepository::class, Repository::class);
    }

    /**
     * Register all the commands and handlers
     */
    public function boot()
    {
    }

}
