<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Terrain\Model;

use Vera\Rover\Domain\Shared\ValueObject\Position;
use Vera\Rover\Domain\Terrain\ValueObject\Obstacle;

final class Terrain
{

    public Position $position;


    public function __construct(Position $position, Obstacle $obstacle)
    {
        $this->position = $position;
        $this->obstacle = $obstacle;
    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->position;
    }

}
