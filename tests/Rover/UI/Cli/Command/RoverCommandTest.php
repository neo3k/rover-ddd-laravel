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

    public function test_cli_rover_success_cases(): void
    {
        foreach ($this->successCasesProvider() as $case) {
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

    public function test_cli_rover_fail_cases(): void
    {
        foreach ($this->failCasesProvider() as $case) {
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

    private function successCasesProvider(): array
    {
        $cases = [];

        $cases[] = [
            'inputs' => ['5', '5', 'No', '1', '2', 'N', 'LFLFLFLFF'],
            'expectedOutput' => '1 3 N'
        ];

        $cases[] = [
            'inputs' => ['5', '5', 'No', '3', '3', 'E', 'FFRFFRFRRF'],
            'expectedOutput' => '5 1 E'
        ];

        $cases[] = [
            'inputs' => ['5', '5', 'No', '3', '3', 'E', 'FFRFFRFRRF'],
            'expectedOutput' => '5 1 E'
        ];

        $cases[] = [
            'inputs' => ['5', '5', 'No', '1', '2', 'N', 'FFFFFFFFF'],
            'expectedOutput' => 'Rover has reached the limit of the terrain'
        ];

        $cases[] = [
            'inputs' => ['5', '5', 'No', '1', '2', 'N', 'FFFFFFFFF'],
            'expectedOutput' => '1 5 N'
        ];

        return $cases;
    }

    private function failCasesProvider(): array
    {
        $cases = [];

        $cases[] = [
            'inputs' => ['5', '5', 'No', '6', '6', 'E', 'FF'],
            'expectedOutput' => 'Rover cannot be placed outside the boundaries of the terrain'
        ];

        $cases[] = [
            'inputs' => ['5', '5', 'Yes', '0', '1', 'No', '0', '1', 'E', 'FF'],
            'expectedOutput' => 'You cannot add an obstacle in the initial position of the Rover'
        ];

        $cases[] = [
            'inputs' => ['J', '5', 'Yes', '0', '2', 'No', '0', '1', 'E', 'FF'],
            'expectedOutput' => 'Should be a positive integer'
        ];

        return $cases;
    }

}
