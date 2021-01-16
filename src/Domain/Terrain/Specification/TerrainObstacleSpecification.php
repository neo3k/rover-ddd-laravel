<?php


namespace Vera\Rover\Domain\Terrain\Specification;


use Vera\Rover\Domain\Rover\Model\Rover;
use Vera\Rover\Domain\Terrain\ValueObject\Obstacle;

class TerrainObstacleSpecification
{
    public function ensureObstaclesAreInAllowedPosition(Rover $rover): ?bool
    {
        foreach ($rover->terrain->obstacle->__toArray() as $obstacle) {
            if ($obstacle->x()->__toInt() === $rover->getPosition()->x()->__toInt() && $obstacle->y()->__toInt(
                ) === $rover->getPosition()->y()->__toInt()) {
                throw new \InvalidArgumentException(
                    'You cannot add an obstacle in the initial position of the Rover'
                );
            }
            foreach ($obstacle as $coordinate) {
                if ($coordinate->__toInt() < 0) {
                    throw new \InvalidArgumentException(
                        sprintf('Obstacle coordinate cannot be less than zero: %s', $coordinate->__toInt())
                    );
                }
            }
        }

        return true;
    }
}
