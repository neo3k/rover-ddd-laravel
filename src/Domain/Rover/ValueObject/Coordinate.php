<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Rover\ValueObject;

final class Coordinate
{

    /**
     * @var int
     */
    private $coordinate = 0;

    public function __construct(int $coordinate)
    {
        $this->coordinate = $coordinate;
    }

    /**
     * @param int $coordinate
     * @return $this
     */
    public function sumCoordinate(int $coordinate): self
    {
        return new self($this->coordinate + $coordinate);
    }

    public function __toString(): string
    {
        return (string)$this->coordinate;
    }
}
