<?php

namespace Tests\Rover\Domain\Rover\Specification;

use Ramsey\Uuid\Uuid;
use Vera\Rover\Domain\Rover\Model\Rover;
use Vera\Rover\Domain\Rover\Specification\RoverSpecification;
use PHPUnit\Framework\TestCase;
use Vera\Rover\Domain\Rover\ValueObject\Direction;
use Vera\Rover\Domain\Rover\ValueObject\Move;
use Vera\Rover\Domain\Shared\ValueObject\Position;
use Vera\Rover\Domain\Terrain\Model\Terrain;
use Vera\Rover\Domain\Terrain\ValueObject\Obstacle;

class RoverSpecificationTest extends TestCase
{

    private $rover;
    private $move;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rover = new Rover(
            Uuid::uuid1(),
            new Terrain(Position::fromString('5', '5'), Obstacle::fromArray([['0','1']])),
            Position::fromString('0', '0'),
            Direction::fromString('E')
        );
        $this->move = new Move('F');
    }

    /**
     * @test
     */
    public function test_rover_move_if_there_are_no_obstacles_ahead(): void
    {
        $validation = (new RoverSpecification())->ensureNotObstacleInFront(
            $this->rover,
            $this->move
        );

        self::assertTrue($validation);
    }

    /**
     * @test
     */
    public function test_rover_detects_an_obstacle_and_stops(): void
    {
        $this->rover = new Rover(
            Uuid::uuid1(),
            new Terrain(Position::fromString('5', '5'), Obstacle::fromArray([['1','0']])),
            Position::fromString('0', '0'),
            Direction::fromString('E')
        );

        $this->expectException(\InvalidArgumentException::class);

        (new RoverSpecification())->ensureNotObstacleInFront(
            $this->rover,
            $this->move
        );
    }

    /**
     * @test
     */
    public function test_rover_position_is_inside_the_bounds(): void
    {
        $validation = (new RoverSpecification())->ensurePositionIsInsideBounds(
            $this->rover
        );

        self::assertTrue($validation);
    }

    /**
     * @test
     */
    public function test_rover_position_is_outside_the_bounds(): void
    {
        $this->rover = new Rover(
            Uuid::uuid1(),
            new Terrain(Position::fromString('5', '5'), Obstacle::fromArray([['1','0']])),
            Position::fromString('6', '0'),
            Direction::fromString('E')
        );

        $this->expectException(\InvalidArgumentException::class);

        (new RoverSpecification())->ensurePositionIsInsideBounds(
            $this->rover
        );
    }
}
