<?php

namespace Tests\Rover\App\Command\Rover\Sequence;

use App\Command\Shared\CommandBusStatus;
use Symfony\Component\Console\Command\Command;
use Vera\Rover\App\Command\Rover\Sequence\RoverSequence;
use PHPUnit\Framework\TestCase;
use Vera\Rover\Domain\Rover\Model\Rover;
use Vera\Rover\Domain\Rover\Specification\RoverDirectionSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverMoveSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverPositionSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverRotateSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverSpecification;
use Vera\Rover\Domain\Rover\ValueObject\Direction;
use Vera\Rover\Domain\Rover\ValueObject\Move;
use Vera\Rover\Domain\Shared\ValueObject\Coordinate;
use Vera\Rover\Domain\Shared\ValueObject\Position;
use Vera\Rover\Domain\Terrain\Model\Terrain;
use Vera\Rover\Domain\Terrain\Specification\TerrainObstacleSpecification;
use Vera\Rover\Domain\Terrain\Specification\TerrainPositionSpecification;
use Vera\Rover\Domain\Terrain\ValueObject\Obstacle;

class RoverSequenceUnitTest extends TestCase
{
    protected $mockedRoverDirectionSpecClass;
    protected $mockedRoverMoveSpecClass;
    protected $mockedRoverRotateSpecClass;
    protected $mockedRoverPositionSpecClass;
    protected $mockedRoverSpecClass;
    protected $mockedTerrainPositionSpecClass;
    protected $mockedTerrainObstacleSpecClass;
    protected RoverSequence $roverSequence;
    protected $mockedRoverMoveValueObject;
    private $mockedRover;
    private $mockedTerrain;
    private $mockedSequence;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockedRoverDirectionSpecClass = $this->createMock(RoverDirectionSpecification::class);
        $this->mockedRoverMoveSpecClass = $this->createMock(RoverMoveSpecification::class);
        $this->mockedRoverRotateSpecClass = $this->createMock(RoverRotateSpecification::class);
        $this->mockedRoverPositionSpecClass = $this->createMock(RoverPositionSpecification::class);
        $this->mockedRoverSpecClass = $this->createMock(RoverSpecification::class);
        $this->mockedTerrainPositionSpecClass = $this->createMock(TerrainPositionSpecification::class);
        $this->mockedTerrainObstacleSpecClass = $this->createMock(TerrainObstacleSpecification::class);
        $this->mockedRover = $this->createMock(Rover::class);
        $this->mockedTerrain = $this->createMock(Terrain::class);
        $this->mockedRoverMoveValueObject = $this->createMock(Move::class);
        $this->roverSequence = new RoverSequence();
        $this->mockedSequence = [];
    }


    /**
     *
     * @return void
     */
    public function test_rover_sequence_exec_works(): void
    {

        $this->mockedTerrain = new Terrain(Position::fromString('5', '5'), Obstacle::fromArray([]));
        $this->mockedRover->terrain = $this->mockedTerrain;
        $this->mockedRover->position = Position::fromString('0', '0');
        $this->mockedSequence = ['F'];
        $this->mockedRover->method('getTerrain')->willReturn(
            new Terrain(new Position(new Coordinate(5), new Coordinate(5)), new Obstacle([])));
        $this->mockedRover->method('getDirection')->willReturn(new Direction('N'));
        $this->mockedRover->method('getPosition')->willReturn(new Position(new Coordinate(0), new Coordinate(0)));
        $this->mockedRoverDirectionSpecClass->method('ensureIsAllowedCardinatePoint')->willReturn(true);
        $this->mockedRoverMoveSpecClass->method('ensureIsAllowedMoveCommand')->willReturn(true);
        $this->mockedRoverPositionSpecClass->method('ensureIsAllowedPosition')->willReturn(true);
        $this->mockedRoverSpecClass->method('ensurePositionIsInsideBounds')->willReturn(true);
        $this->mockedTerrainPositionSpecClass->method('ensureIsAllowedPosition')->willReturn(true);
        $this->mockedTerrainObstacleSpecClass->method('ensureObstaclesAreInAllowedPosition')->willReturn(true);

        $result = $this->roverSequence->exec(
            $this->mockedRover,
            $this->mockedSequence,
            $this->mockedRoverDirectionSpecClass,
            $this->mockedRoverMoveSpecClass,
            $this->mockedRoverRotateSpecClass,
            $this->mockedRoverPositionSpecClass,
            $this->mockedRoverSpecClass,
            $this->mockedTerrainPositionSpecClass,
            $this->mockedTerrainObstacleSpecClass
        );

        self::assertEquals((new CommandBusStatus(1))->getStatus(), $result->getStatus());

    }

    /**
     *
     * @return void
     */
    public function test_rover_sequence_exec_fails(): void
    {
        $this->mockedTerrain = new Terrain(Position::fromString('5', '5'), Obstacle::fromArray([]));
        $this->mockedRover->terrain = $this->mockedTerrain;
        $this->mockedRover->position = Position::fromString('-50', '0');
        $this->mockedSequence = ['F'];
        $this->mockedRover->method('getTerrain')->willReturn(
            new Terrain(new Position(new Coordinate(5), new Coordinate(5)), new Obstacle([])));
        $this->mockedRover->method('getDirection')->willReturn(new Direction('N'));
        $this->mockedRover->method('getPosition')->willReturn(new Position(new Coordinate(0), new Coordinate(0)));
        $this->mockedRoverDirectionSpecClass->method('ensureIsAllowedCardinatePoint')->willReturn(true);
        $this->mockedRoverMoveSpecClass->method('ensureIsAllowedMoveCommand')->willReturn(true);
        $this->mockedRoverPositionSpecClass->method('ensureIsAllowedPosition')->willReturn(null)->willThrowException(new \InvalidArgumentException('Coordinate cannot be less than zero: -50'));
        $this->mockedRoverSpecClass->method('ensurePositionIsInsideBounds')->willReturn(true);
        $this->mockedTerrainPositionSpecClass->method('ensureIsAllowedPosition')->willReturn(true);
        $this->mockedTerrainObstacleSpecClass->method('ensureObstaclesAreInAllowedPosition')->willReturn(true);

        $result = $this->roverSequence->exec(
            $this->mockedRover,
            $this->mockedSequence,
            $this->mockedRoverDirectionSpecClass,
            $this->mockedRoverMoveSpecClass,
            $this->mockedRoverRotateSpecClass,
            $this->mockedRoverPositionSpecClass,
            $this->mockedRoverSpecClass,
            $this->mockedTerrainPositionSpecClass,
            $this->mockedTerrainObstacleSpecClass
        );

        self::assertEquals((new CommandBusStatus(0))->getStatus(), $result->getStatus());

    }
}
