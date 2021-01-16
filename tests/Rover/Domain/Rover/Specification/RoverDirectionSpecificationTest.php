<?php

namespace Tests\Rover\Domain\Rover\Specification;

use Vera\Rover\Domain\Rover\Specification\RoverDirectionSpecification;
use PHPUnit\Framework\TestCase;
use Vera\Rover\Domain\Rover\ValueObject\Direction;

class RoverDirectionSpecificationTest extends TestCase
{

    private $direction;

    protected function setUp(): void
    {
        parent::setUp();

        $this->direction = new Direction('N');
    }

    /**
     * @test
     */
    public function test_direction_is_available(): void
    {
        $validation = (new RoverDirectionSpecification())->ensureIsAllowedCardinatePoint(
            $this->direction
        );

        self::assertTrue($validation);
    }

    /**
     * @test
     */
    public function test_unrecognized_direction(): void
    {
        $this->direction = New Direction('X');

        $this->expectException(\InvalidArgumentException::class);

        (new RoverDirectionSpecification())->ensureIsAllowedCardinatePoint(
            $this->direction
        );
    }
}
