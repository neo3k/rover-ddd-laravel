<?php


namespace Tests\Rover\Domain\Shared\ValueObject;


use PHPUnit\Framework\TestCase;
use Vera\Rover\Domain\Shared\ValueObject\Coordinate;

class CoordinateTest extends TestCase
{
    private int $coordinate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->coordinate = 5;
    }

    /**
     * @test
     */
    public function test_sum_coordinate(): void
    {
        $initialCoordinate = new Coordinate(6);
        $validation = (new Coordinate($this->coordinate))->sumCoordinate(1);
        self::assertEquals($initialCoordinate, $validation);
    }
}
