<?php


namespace Tests\Rover\UI\Cli\Command;


use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;
use Vera\Rover\UI\Cli\Command\Rover;

class RoverCommandTest extends TestCase
{

    private $commandTester;
    private $command;

    protected function setUp(): void
    {
        parent::setUp();

        $application = new ConsoleApplication();

        $testedCommand = $this->app->make(Rover::class);
        $testedCommand->setLaravel(app());
        $application->add($testedCommand);

        $this->command = $application->find('rover:start');

        $this->commandTester = new CommandTester($this->command);
    }

    public function test_cli_rover_command(): void
    {
        foreach ($this->casesProvider() as $case) {
            $this->commandTester->setInputs($case['inputs']);

            $this->commandTester->execute(
                [
                    'command' => $this->command->getName(),
                ]
            );

            $output = $this->commandTester->getDisplay();

            self::assertStringContainsString($case['expectedOutput'], $output);
        }
    }

    private function casesProvider(): array
    {
        $cases = [];

        $cases[] = [
            'inputs' => ['5', '5', 'No', '6', '6', 'N', 'F'],
            'expectedOutput' => 'Rover cannot be placed outside the boundaries of the terrain'
        ];

        return $cases;
    }

}
