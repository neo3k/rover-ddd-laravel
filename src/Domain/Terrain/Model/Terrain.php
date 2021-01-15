<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Terrain\Model;

use Vera\Rover\Domain\Shared\ValueObject\Coordinate;
use Vera\Rover\Domain\Shared\ValueObject\Position;

final class Terrain
{

    public Position $position;


    public function __construct(Position $position)
    {
        $this->position = $position;
    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->position;
    }

}
