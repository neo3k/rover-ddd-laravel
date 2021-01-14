<?php

declare(strict_types=1);

namespace Vera\Rover\Infrastructure\Rover\Specification;


use Vera\Rover\Domain\Rover\ValueObject\Direction;

class RoverDirectionSpecification
{
    /**
     * @param Direction $direction
     * @return bool|null
     */
    public function ensureIsAllowedCardinatePoint(Direction $direction): ?bool
    {
        if (!in_array($direction->__toString(), $direction::getAllowedDirections(), true)) {
            throw new \InvalidArgumentException(sprintf('Unrecognized Direction: <%s>', $direction));
        }

        return true;
    }
}
