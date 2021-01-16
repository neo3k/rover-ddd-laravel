<?php


namespace Tests\Rover\Domain\Rover\ValueObject;


use PHPUnit\Framework\TestCase;
use Vera\Rover\Domain\Rover\ValueObject\Rotate;

class RotateTest extends TestCase
{

    private $command;

    protected function setUp(): void
    {
        parent::setUp();
        $this->command = 'L';
    }

    /**
     * @test
     */
    public function test_get_available_rotate_commands(): void
    {
        $validation = (new Rotate($this->command))->getAllowedRotateCommands();

        self::assertIsArray($validation);
    }
}
