<?php

declare(strict_types=1);

namespace App\Query\Rover;

use Vera\Rover\Domain\Rover\Model\Rover;

class CreateRover
{

    public Rover $rover;

    public function __construct(Rover $rover)
    {
        $this->id = $rover->getId();
        $this->rover = $rover;
    }
}
