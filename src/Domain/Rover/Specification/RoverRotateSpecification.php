<?php


namespace Vera\Rover\Domain\Rover\Specification;


use Vera\Rover\Domain\Rover\ValueObject\Rotate;

class RoverRotateSpecification
{
    public function ensureIsAllowedMoveCommand(Rotate $rotate): ?bool
    {
        if (!in_array($rotate, Rotate::getAllowedRotateCommands())) {
            throw new \InvalidArgumentException(sprintf('Unrecognized Command: <%s>', $rotate));
        }

        return true;
    }
}
