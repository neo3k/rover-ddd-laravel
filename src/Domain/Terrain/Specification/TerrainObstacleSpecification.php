<?php


namespace Vera\Rover\Domain\Terrain\Specification;


use Vera\Rover\Domain\Terrain\ValueObject\Obstacle;

class TerrainObstacleSpecification
{
    public function ensureObstaclesAreInAllowedPosition(Obstacle $obstacles): ?bool
    {
        foreach ($obstacles->__toArray() as $obstacle) {
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
