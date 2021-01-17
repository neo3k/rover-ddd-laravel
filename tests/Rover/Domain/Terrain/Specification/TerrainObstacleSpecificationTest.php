<?php


namespace Tests\Rover\Domain\Terrain\Specification;


use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Vera\Rover\Domain\Rover\Model\Rover;
use Vera\Rover\Domain\Rover\ValueObject\Direction;
use Vera\Rover\Domain\Shared\ValueObject\Position;
use Vera\Rover\Domain\Terrain\Model\Terrain;
use Vera\Rover\Domain\Terrain\Specification\TerrainObstacleSpecification;
use Vera\Rover\Domain\Terrain\ValueObject\Obstacle;

class TerrainObstacleSpecificationTest extends TestCase
{
    private $rover;
    private $obstacles;

    protected function setUp(): void
    {
        parent::setUp();
        $this->obstacles = Obstacle::fromArray([['2','3'],['4','5']]);
        $this->rover = new Rover(
            Uuid::uuid1(),
            new Terrain(Position::fromString('5', '5'), $this->obstacles),
            Position::fromString('2', '3'),
            Direction::fromString('E')
        );
    }

    public function test_cannot_add_obstacle_in_rover_initial_position(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (New TerrainObstacleSpecification())->ensureObstaclesAreInAllowedPosition($this->rover);
    }

    public function test_can_add_obstacle_if_is_not_rover_initial_position(): void
    {
        $this->rover = new Rover(
            Uuid::uuid1(),
            new Terrain(Position::fromString('5', '5'), $this->obstacles),
            Position::fromString('4', '4'),
            Direction::fromString('E')
        );
        $validation = (New TerrainObstacleSpecification())->ensureObstaclesAreInAllowedPosition($this->rover);

        self::assertTrue($validation);
    }

    public function test_cannot_add_obstacle_outside_of_the_bounds(): void
    {
        $this->rover = new Rover(
            Uuid::uuid1(),
            new Terrain(Position::fromString('5', '5'), Obstacle::fromArray([['2','-3'],['-4','5']])),
            Position::fromString('4', '4'),
            Direction::fromString('E')
        );
        $validation = (New TerrainObstacleSpecification())->ensureObstaclesAreInAllowedPosition($this->rover);

        self::assertTrue($validation);
    }
}
