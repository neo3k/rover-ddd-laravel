<?php


namespace Vera\Rover\Domain\Rover\Specification;


use Vera\Rover\Domain\Rover\ValueObject\Move;

class RoverMoveSpecification
{
    public function ensureIsAllowedMoveCommand(Move $move): ?bool
    {
        if (!in_array($move, Move::getAllowedMoveCommands())) {
            throw new \InvalidArgumentException(sprintf('Unrecognized Command: <%s>', $move));
        }

        return true;
    }
}
