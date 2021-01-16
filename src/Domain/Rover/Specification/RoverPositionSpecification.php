<?php


namespace Vera\Rover\Domain\Rover\Specification;


use Vera\Rover\Domain\Shared\ValueObject\Position;

class RoverPositionSpecification
{
    public function ensureIsAllowedPosition(Position $position): ?bool
    {
        foreach($position->__toArray() as $coordinate)
        {
            if($coordinate->__toInt() < 0)
            {
                throw new \InvalidArgumentException(sprintf('Coordinate cannot be less than zero: %s', $coordinate->__toInt()));
            }
        }

        return true;
    }
}
