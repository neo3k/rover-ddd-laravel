<?php


namespace Tests\Rover\Domain\Rover\ValueObject;


use PHPUnit\Framework\TestCase;
use Vera\Rover\Domain\Rover\ValueObject\Move;
use Vera\Rover\Domain\Rover\ValueObject\Rotate;

class MoveTest extends TestCase
{

    private $command;

    protected function setUp(): void
    {
        parent::setUp();
        $this->command = 'F';
    }

    /**
     * @test
     */
    public function test_get_available_move_commands(): void
    {
        $validation = (new Move($this->command))->getAllowedMoveCommands();

        self::assertIsArray($validation);
    }

    /**
     * @test
     */
    public function test_calculate_move_factor(): void
    {
        $move = new Move($this->command);
        $value = -1;

        $shouldBe = $move::MOVEMENT_FACTOR * $value;

        $validation = $move->factor(-1);

        self::assertEquals($shouldBe, $validation);
    }
}
