<?php

namespace Tests\Rover\Domain\Rover\Model;

use Ramsey\Uuid\Uuid;
use Vera\Rover\Domain\Rover\Model\Rover;
use PHPUnit\Framework\TestCase;
use Vera\Rover\Domain\Rover\ValueObject\Direction;
use Vera\Rover\Domain\Rover\ValueObject\Move;
use Vera\Rover\Domain\Rover\ValueObject\Rotate;
use Vera\Rover\Domain\Shared\ValueObject\Position;
use Vera\Rover\Domain\Terrain\Model\Terrain;
use Vera\Rover\Domain\Terrain\ValueObject\Obstacle;

class RoverTest extends TestCase
{

    private $terrain;
    private $position;
    private $direction;
    private $id;

    protected function setUp(): void
    {
        parent::setUp();
        $this->id = Uuid::uuid1();
        $this->terrain = new Terrain(Position::fromString('5', '5'), Obstacle::fromArray([]));
        $this->position = Position::fromString('0', '0');
        $this->direction = Direction::fromString('N');
    }

    /**
     * @test
     */
    public function test_rover_move(): void
    {
        $validation = new Rover($this->id, $this->terrain, $this->position, $this->direction);
        $validation->move(Move::fromString('F'));
        self::assertEquals('0 1 N', $validation);

    }

    /**
     * @test
     */
    public function test_rover_rotate(): void
    {
        $validation = new Rover($this->id, $this->terrain, $this->position, $this->direction);
        $validation->rotate(Rotate::fromString('L'));
        self::assertEquals('0 0 W', $validation);

    }

    /**
     * @test
     */
    public function test_rover_get_direction(): void
    {
        $validation = new Rover($this->id, $this->terrain, $this->position, $this->direction);
        self::assertEquals($validation->getDirection(), $this->direction);

    }

    /**
     * @test
     */
    public function test_rover_get_position(): void
    {
        $validation = new Rover($this->id, $this->terrain, $this->position, $this->direction);
        self::assertEquals($validation->getPosition(), $this->position);

    }

    /**
     * @test
     */
    public function test_rover_get_terrain(): void
    {
        $validation = new Rover($this->id, $this->terrain, $this->position, $this->direction);
        self::assertEquals($validation->getTerrain(), $this->terrain);

    }


}
