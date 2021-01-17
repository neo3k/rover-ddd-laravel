<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Rover\Model;

interface RoverRepository
{

    public function put(string $id, Rover $rover): void;
    public function get(string $id): ?Rover;
}
