<?php

namespace Tests\Rover\Domain\Rover\Specification;

use Vera\Rover\Domain\Rover\Specification\RoverPositionSpecification;
use PHPUnit\Framework\TestCase;
use Vera\Rover\Domain\Shared\ValueObject\Coordinate;
use Vera\Rover\Domain\Shared\ValueObject\Position;

class RoverPositionSpecificationTest extends TestCase
{

    private $position;

    protected function setUp(): void
    {
        parent::setUp();
        $this->position = new Position(new Coordinate(5), new Coordinate(2));
    }

    /**
     * @test
     */
    public function test_correct_position(): void
    {
        $validation = (new RoverPositionSpecification())->ensureIsAllowedPosition(
            $this->position
        );

        self::assertTrue($validation);
    }

    /**
     * @test
     */
    public function test_incorrect_position(): void
    {
        $this->position = new Position(new Coordinate(5), new Coordinate(-25));

        $this->expectException(\InvalidArgumentException::class);

        (new RoverPositionSpecification())->ensureIsAllowedPosition(
            $this->position
        );
    }
}
