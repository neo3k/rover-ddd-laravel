<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Rover\Model;

use Vera\Rover\Domain\Rover\ValueObject\Direction;
use Vera\Rover\Domain\Rover\ValueObject\Move;
use Vera\Rover\Domain\Shared\ValueObject\Position;
use Vera\Rover\Domain\Rover\ValueObject\Rotate;
use Vera\Rover\Domain\Terrain\Model\Terrain;

class Rover
{

    public Position $position;
    public Direction $direction;


    public function __construct(Terrain $terrain, Position $position, Direction $direction)
    {
        $this->terrain = $terrain;
        $this->position = $position;
        $this->direction = $direction;
    }

    public function move(Move $move): void
    {
        $axisValue = $move->factor($this->direction->axisValue());

        if (Direction::X_AXIS === $this->direction->axis()) {
            $this->position = $this->position->translate(
                $this->position->x()->sumCoordinate($axisValue),
                $this->position->y()
            );

            return;
        }

        $this->position = $this->position->translate(
            $this->position->x(),
            $this->position->y()->sumCoordinate($axisValue)
        );

    }

    /**
     * @param Rotate $rotate
     */
    public function rotate(Rotate $rotate): void
    {
        $this->direction = $this->direction->heading($rotate);
    }

    /**
     * @return Direction
     */
    public function getDirection(): Direction
    {
        return $this->direction;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @return Terrain
     */
    public function getTerrain(): Terrain
    {
        return $this->terrain;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)($this->position . ' ' . $this->direction);
    }

}
