<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Rover\Specification;


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
            $error_msg = sprintf('Unrecognized Direction: %s - ', $direction->__toString());
            $error_msg .= 'The direction should be ';
            $error_msg .= implode(', ', $direction::getAllowedDirections());
            throw new \InvalidArgumentException($error_msg);
        }

        return true;
    }
}
