<?php

declare(strict_types=1);

namespace Vera\Rover\App\Command\Rover\Sequence;

use Gears\CQRS\AbstractCommand;

use Vera\Rover\Domain\Rover\Model\Rover;
use Vera\Rover\Domain\Rover\ValueObject\Direction;
use Vera\Rover\Domain\Rover\ValueObject\Position;

class RoverSequenceCommand extends AbstractCommand
{

    public Rover $rover;

    public function roverInit(int $position_x, int $position_y, string $direction, array $sequence)
    {
        $this->rover = new Rover(Position::fromInt($position_x, $position_y), Direction::fromString($direction));
        $this->sequence = $sequence;
    }
}
