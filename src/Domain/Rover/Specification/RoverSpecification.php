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

            foreach ($rover->terrain->obstacle->__toArray() as $obstacle) {
                if ($obstacle[0]->__toInt() === $rover->position->x()->__toInt() + $axisValue && $obstacle[1]->__toInt(
                    ) === $rover->position->y()->__toInt()) {

                    throw new \InvalidArgumentException(
                        'Rover cannot move forward, there is an obstacle (' . $obstacle[0] . ',' . $obstacle[1] . '). The rest of the sequence is cancelled.'
                    );
                }
            }
        }

        if ($axis === Direction::Y_AXIS) {
            if ($rover->terrain->position->y()->__toInt() < $rover->position->y()->__toInt(
                ) + $axisValue || $rover->position->y()->__toInt() + $axisValue < 0) {
                throw new \InvalidArgumentException('Rover has reached the limit of the terrain');
            }

            foreach ($rover->terrain->obstacle->__toArray() as $obstacle) {
                if ($obstacle[0]->__toInt() === $rover->position->x()->__toInt() && $obstacle[1]->__toInt(
                    ) === $rover->position->y()->__toInt() + $axisValue) {

                    throw new \InvalidArgumentException(
                        'Rover cannot move forward, there is an obstacle (' . $obstacle[0] . ',' . $obstacle[1] . '). The rest of the sequence is cancelled.'
                    );
                }
            }
        }

        return true;
    }

    /**
     * @param Rover $rover
     * @return bool|null
     */
    public function ensurePositionIsInsideBounds(Rover $rover): ?bool
    {
        if ($rover->position->x()->__toInt() > $rover->terrain->position->x()->__toInt()) {
            throw new \InvalidArgumentException('Rover cannot be placed outside the boundaries of the terrain');
        }

        if ($rover->position->y()->__toInt() > $rover->terrain->position->y()->__toInt()) {
            throw new \InvalidArgumentException('Rover cannot be placed outside the boundaries of the terrain');
        }

        return true;
    }
}
