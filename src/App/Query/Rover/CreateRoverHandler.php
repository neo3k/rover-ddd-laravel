<?php

declare(strict_types=1);

namespace App\Query\Rover;

use Illuminate\Contracts\Cache\Repository;
use Vera\Rover\Domain\Rover\Model\RoverRepository;

class CreateRoverHandler
{

    public function __construct(Repository $roverRepository)
    {
        $this->roverRepository = $roverRepository;
    }

    public function handle(CreateRover $query) {
        return $this->roverRepository->put($query->id, $query->rover);
    }
}
