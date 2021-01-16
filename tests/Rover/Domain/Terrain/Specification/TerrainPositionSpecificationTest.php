<?php


namespace Tests\Rover\Domain\Terrain\Specification;


use Tests\TestCase;
use Vera\Rover\Domain\Shared\ValueObject\Coordinate;
use Vera\Rover\Domain\Shared\ValueObject\Position;
use Vera\Rover\Domain\Terrain\Specification\TerrainPositionSpecification;

class TerrainPositionSpecificationTest extends TestCase
{
    private $position;

    protected function setUp(): void
    {
        parent::setUp();
        $this->position = new Position(new Coordinate(-5), new Coordinate(1));
    }

    public function test_terrain_position_cannot_have_negative_coordinates(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new TerrainPositionSpecification())->ensureIsAllowedPosition($this->position);
    }

    public function test_terrain_position_with_allowed_coordinates(): void
    {
        $this->position = new Position(new Coordinate(5), new Coordinate(1));
        $validation = (new TerrainPositionSpecification())->ensureIsAllowedPosition($this->position);

        self::assertTrue($validation);
    }
}
