<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Rover\Model;

use Vera\Rover\Domain\Rover\ValueObject\Direction;
use Vera\Rover\Domain\Rover\ValueObject\Move;
use Vera\Rover\Domain\Shared\ValueObject\Coordinate;
use Vera\Rover\Domain\Shared\ValueObject\Position;
use Vera\Rover\Domain\Rover\ValueObject\Rotate;
use Vera\Rover\Domain\Terrain\Model\Terrain;
use Vera\Rover\Domain\Terrain\ValueObject\Obstacle;

class Rover
{

    public string $id;
    public Position $position;
    public Direction $direction;


    public function __construct(string $id, Terrain $terrain, Position $position, Direction $direction)
    {
        $this->id = $id;
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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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

    public static function fromArray($rover): Rover
    {
        return new self(
            $rover['id'],
            new Terrain(
                new Position(new Coordinate($rover['terrain_x']), new Coordinate($rover['terrain_y'])),
                (new Obstacle())->fromArray($rover['obstacles'])
            ),
            new Position(new Coordinate($rover['rover_x']), new Coordinate($rover['rover_y'])),
            new Direction($rover['direction'])
        );
    }

}
