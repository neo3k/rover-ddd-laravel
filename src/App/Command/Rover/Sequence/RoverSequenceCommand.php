<?php

declare(strict_types=1);

namespace Vera\Rover\App\Command\Rover\Sequence;


use Vera\Rover\Domain\Rover\Model\Rover;
use Vera\Rover\Domain\Rover\ValueObject\Direction;
use Vera\Rover\Domain\Shared\ValueObject\Position;
use Vera\Rover\Domain\Terrain\Model\Terrain;

class RoverSequenceCommand
{

    public Rover $rover;
    public array $sequence;

    public function __construct(
        string $terrain_max_x,
        string $terrain_max_y,
        string $position_x,
        string $position_y,
        string $direction,
        array $sequence
    ) {
        $this->terrain = new Terrain(Position::fromString($terrain_max_x, $terrain_max_y));
        $this->rover = new Rover(
            $this->terrain,
            Position::fromString($position_x, $position_y),
            Direction::fromString($direction)
        );
        $this->sequence = $sequence;
    }
}
