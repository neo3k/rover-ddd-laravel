<?php

declare(strict_types=1);

namespace Vera\Rover\App\Command\Rover\Sequence;


use Vera\Rover\Domain\Rover\Model\Rover;
use Vera\Rover\Domain\Rover\ValueObject\Direction;
use Vera\Rover\Domain\Rover\ValueObject\Position;

class RoverSequenceCommand
{

    public Rover $rover;
    public array $sequence;

    public function __construct(string $position_x, string $position_y, string $direction, array $sequence)
    {
        $this->rover = new Rover(Position::fromString($position_x, $position_y), Direction::fromString($direction));
        $this->sequence = $sequence;
    }
}
