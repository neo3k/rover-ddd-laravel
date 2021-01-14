<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Rover\ValueObject;

final class Direction
{

    private const NORTH = 'N';
    private const SOUTH = 'S';
    private const EAST = 'E';
    private const WEST = 'W';

    public const X_AXIS = 'X';
    public const Y_AXIS = 'Y';

    private const ALLOWED_DIRECTIONS = [
        self::NORTH,
        self::EAST,
        self::SOUTH,
        self::WEST
    ];

    private $direction;

    public function __construct(string $direction)
    {
        $this->direction = $direction;
    }

    /**
     * @param string $direction
     * @return static
     */
    public static function fromString(string $direction): self
    {
        return new self($direction);
    }

    public function heading(Rotate $rotate): self
    {
        if (Rotate::COMMAND_ROTATE_LEFT === (string)$rotate) {
            return new self($this->cardinalRotateLeft());
        }

        return new self($this->cardinalRotateRight());
    }

    private function cardinalRotateLeft(): string
    {
        $arrayKey = array_search($this->direction, self::ALLOWED_DIRECTIONS);
        if ($arrayKey === 0) {
            $newKey = 3;
            return self::ALLOWED_DIRECTIONS[$newKey];
        }
        $newKey = $arrayKey - 1;
        return self::ALLOWED_DIRECTIONS[$newKey];
    }

    private function cardinalRotateRight(): string
    {
        $arrayKey = array_search($this->direction, self::ALLOWED_DIRECTIONS);
        $newKey = ($arrayKey + 1) % 4;
        return self::ALLOWED_DIRECTIONS[$newKey];
    }

    public function axis(): string
    {
        $axis = match ($this->direction) {
            self::NORTH => self::Y_AXIS,
            self::WEST => self::X_AXIS,
            self::SOUTH => self::Y_AXIS,
            self::EAST => self::X_AXIS,
        };

        return (string)$axis;
    }

    public function axisValue(): int
    {
        $axisValue = match ($this->direction) {
            self::NORTH => 1,
            self::WEST => 1,
            self::SOUTH => -1,
            self::EAST => -1,
        };

        return (int)$axisValue;
    }

    public static function getAllowedDirections(): array
    {
        return self::ALLOWED_DIRECTIONS;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->direction;
    }
}
