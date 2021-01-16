<?php

namespace Tests\Rover\Domain\Rover\Specification;

use Vera\Rover\Domain\Rover\Specification\RoverMoveSpecification;
use PHPUnit\Framework\TestCase;
use Vera\Rover\Domain\Rover\ValueObject\Move;

class RoverMoveSpecificationTest extends TestCase
{

    private $command;

    protected function setUp(): void
    {
        parent::setUp();
        $this->command = new Move('F');
    }

    /**
     * @test
     */
    public function test_move_correct_command_is_available(): void
    {
        $validation = (new RoverMoveSpecification())->ensureIsAllowedMoveCommand(
            $this->command
        );

        self::assertTrue($validation);
    }

    /**
     * @test
     */
    public function test_unrecognized_move_command(): void
    {
        $this->command = New Move('X');

        $this->expectException(\InvalidArgumentException::class);

        (new RoverMoveSpecification())->ensureIsAllowedMoveCommand(
            $this->command
        );
    }
}
