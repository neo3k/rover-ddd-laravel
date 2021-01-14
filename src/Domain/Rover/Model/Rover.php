<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Rover\Model;

use Vera\Rover\Domain\Rover\ValueObject\Direction;
use Vera\Rover\Domain\Rover\ValueObject\Move;
use Vera\Rover\Domain\Rover\ValueObject\Position;
use Vera\Rover\Domain\Rover\ValueObject\Rotate;

final class Rover
{

    private Position $position;
    private Direction $direction;


    public function __construct(Position $position, Direction $direction)
    {
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
    public function __toString(): string
    {
        return (string)($this->position . ' ' . $this->direction);
    }

}
