<?php


namespace Tests\Rover\Domain\Shared\ValueObject;


use PHPUnit\Framework\TestCase;
use Vera\Rover\Domain\Shared\ValueObject\Coordinate;
use Vera\Rover\Domain\Shared\ValueObject\Position;

class PositionTest extends TestCase
{
    private Coordinate $x;
    private Coordinate $y;

    protected function setUp(): void
    {
        parent::setUp();
        $this->x = new Coordinate(1);
        $this->y = New Coordinate(2);
    }

    /**
     * @test
     */
    public function test_translate_position_works(): void
    {
        $expectedPosition = new Position(new Coordinate(3), new Coordinate(4));
        $validation = (new Position($this->x,$this->y))->translate(new Coordinate(3), new Coordinate(4));
        self::assertEquals($expectedPosition, $validation);
    }
}
