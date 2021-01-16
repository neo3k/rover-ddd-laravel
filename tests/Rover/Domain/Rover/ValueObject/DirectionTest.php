<?php


namespace Tests\Rover\Domain\Rover\ValueObject;


use PHPUnit\Framework\TestCase;
use Vera\Rover\Domain\Rover\ValueObject\Direction;
use Vera\Rover\Domain\Rover\ValueObject\Rotate;

class DirectionTest extends TestCase
{
    private string $direction;
    private Rotate $rotate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->direction = 'N';
        $this->rotate = New Rotate('R');
    }

    /**
     * @test
     */
    public function test_direction_heading_to_right(): void
    {
        $validation = (new Direction($this->direction))->heading($this->rotate);

        self::assertEquals('E', $validation);
    }

    /**
     * @test
     */
    public function test_direction_heading_to_left(): void
    {
        $this->rotate = new Rotate('L');

        $validation = (new Direction($this->direction))->heading($this->rotate);

        self::assertEquals('W', $validation);
    }

    /**
     * @test
     */
    public function test_north_match_y_axis(): void
    {
        $validation = (new Direction($this->direction))->axis();

        self::assertEquals('Y', $validation);
    }

    /**
     * @test
     */
    public function test_south_match_y_axis(): void
    {
        $this->direction = 'S';

        $validation = (new Direction($this->direction))->axis();

        self::assertEquals('Y', $validation);
    }

    /**
     * @test
     */
    public function test_east_match_x_axis(): void
    {
        $this->direction = 'E';

        $validation = (new Direction($this->direction))->axis();

        self::assertEquals('X', $validation);
    }

    /**
     * @test
     */
    public function test_west_match_x_axis(): void
    {
        $this->direction = 'W';

        $validation = (new Direction($this->direction))->axis();

        self::assertEquals('X', $validation);
    }

    /**
     * @test
     */
    public function test_north_axisvalue_positive(): void
    {
        $this->direction = 'N';

        $validation = (new Direction($this->direction))->axisValue();

        self::assertEquals('1', $validation);
    }

    /**
     * @test
     */
    public function test_south_axisvalue_negative(): void
    {
        $this->direction = 'S';

        $validation = (new Direction($this->direction))->axisValue();

        self::assertEquals('-1', $validation);
    }

    /**
     * @test
     */
    public function test_east_axisvalue_positive(): void
    {
        $this->direction = 'E';

        $validation = (new Direction($this->direction))->axisValue();

        self::assertEquals('1', $validation);
    }

    /**
     * @test
     */
    public function test_west_axisvalue_negative(): void
    {
        $this->direction = 'W';

        $validation = (new Direction($this->direction))->axisValue();

        self::assertEquals('-1', $validation);
    }

    /**
     * @test
     */
    public function test_get_allowed_directions(): void
    {

        $validation = (new Direction($this->direction))->getAllowedDirections();

        self::assertIsArray($validation);
    }
}
