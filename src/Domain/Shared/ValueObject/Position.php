<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Shared\ValueObject;

final class Position
{

    private Coordinate $x;
    private Coordinate $y;

    public function __construct(Coordinate $x, Coordinate $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param Coordinate $x
     * @param Coordinate $y
     * @return static
     */
    public static function translate(Coordinate $x, Coordinate $y): self
    {
        return new self($x, $y);
    }

    /**
     * @param string $x
     * @param string $y
     * @return static
     */
    public static function fromString(string $x, string $y): self
    {
        $x = New Coordinate(intval($x));
        $y = New Coordinate(intval($y));

        return new self($x, $y);
    }

    /**
     * @return Coordinate
     */
    public function x(): Coordinate
    {
        return $this->x;
    }

    /**
     * @return Coordinate
     */
    public function y(): Coordinate
    {
        return $this->y;
    }

    public function __toArray(): array
    {
        return [$this->x, $this->y];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)($this->x . ' ' . $this->y);
    }
}
