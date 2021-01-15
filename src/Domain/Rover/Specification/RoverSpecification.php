<?php

declare(strict_types=1);

namespace Domain\Rover\Specification;


use Vera\Rover\Domain\Rover\Model\Rover;
use Vera\Rover\Domain\Rover\ValueObject\Direction;
use Vera\Rover\Domain\Rover\ValueObject\Move;

class RoverSpecification
{
    /**
     * @param Rover $rover
     * @param Move $move
     * @return bool|null
     */
    public function ensureNotObstacleInFront(Rover $rover, Move $move): ?bool
    {
        $axis = $rover->direction->axis();
        $axisValue = $move->factor($rover->direction->axisValue());

        if ($axis === Direction::X_AXIS) {
            if ($rover->terrain->position->x()->__toInt() < $rover->position->x()->__toInt(
                ) + $axisValue || $rover->position->x()->__toInt() + $axisValue < 0) {
                throw new \InvalidArgumentException('Rover has reached the limit of the terrain');
            }
        }

        if ($axis === Direction::Y_AXIS) {
            if ($rover->terrain->position->y()->__toInt() < $rover->position->y()->__toInt(
                ) + $axisValue || $rover->position->x()->__toInt() + $axisValue < 0) {
                throw new \InvalidArgumentException('Rover has reached the limit of the terrain');
            }
        }

        return true;
    }
}
