<?php

namespace Tests\Rover\Domain\Rover\Specification;

use Vera\Rover\Domain\Rover\Specification\RoverRotateSpecification;
use PHPUnit\Framework\TestCase;
use Vera\Rover\Domain\Rover\ValueObject\Rotate;

class RoverRotateSpecificationTest extends TestCase
{

    private $command;

    protected function setUp(): void
    {
        parent::setUp();
        $this->command = new Rotate('L');
    }

    /**
     * @test
     */
    public function test_rotate_correct_command_is_available(): void
    {
        $validation = (new RoverRotateSpecification())->ensureIsAllowedMoveCommand(
            $this->command
        );

        self::assertTrue($validation);
    }

    /**
     * @test
     */
    public function test_unrecognized_rotate_command(): void
    {
        $this->command = new Rotate('X');

        $this->expectException(\InvalidArgumentException::class);

        (new RoverRotateSpecification())->ensureIsAllowedMoveCommand(
            $this->command
        );
    }
}
