<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Terrain\ValueObject;


use Vera\Rover\Domain\Shared\ValueObject\Coordinate;

final class Obstacle
{
    private $obstacles;

    public function __construct(array $obstacles)
    {
        $this->obstacles = $obstacles;
    }

    public static function fromArray(array $obstacles): self
    {
        $data = [];
        foreach ($obstacles as $obstacle) {
            $x = new Coordinate(intval($obstacle[0]));
            $y = new Coordinate(intval($obstacle[1]));
            $data[] = [$x, $y];
        }
        return new self($data);
    }

    public function __toArray(): array
    {
        return (array)$this->obstacles;
    }

}
