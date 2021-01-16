<?php


namespace Tests\Rover\UI\Cli\Command;


use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RoverCommandTest extends TestCase
{
    public function test_cli_rover_command(): void
    {

        foreach($this->casesProvider() as $case) {
            $this->artisan('rover:start')
                ->expectsQuestion('Terrain Size: Enter Coordinate X', $case['terrain_x'])
                ->expectsQuestion('Terrain Size: Enter Coordinate Y', $case['terrain_y'])
                ->expectsQuestion('Do you want to add an obstacle?', 'No')
                ->expectsQuestion('Rover Starting point: Enter Coordinate X', $case['rover_x'])
                ->expectsQuestion('Rover Starting point: Enter Coordinate Y', $case['rover_y'])
                ->expectsQuestion('Rover Starting point: Enter Direction', $case['rover_direction'])
                ->expectsQuestion('Rover Sequence: Enter Commands (No blank spaces)', $case['sequence'])
                ->assertExitCode($case['success']);
        }
    }

    private function casesProvider(): array
    {
        $cases = [];

        $cases[] = [
            'terrain_x' => '5',
            'terrain_y' => '5',
            'rover_x' => '0',
            'rover_y' => '0',
            'rover_direction' => 'N',
            'sequence' => 'F',
            'expectedOutput' => '0 1 N',
            'success' => 0
        ];

        return $cases;
    }

    private function getConsoleResponse()
    {
        $kernel = $this->app->make(\Illuminate\Contracts\Console\Kernel::class);
        $status = $kernel->handle(
            $input = new \Symfony\Component\Console\Input\ArrayInput([
                                                                        'command' => 'test:command', // put your command name here
                                                                    ]),
            $output = new \Symfony\Component\Console\Output\BufferedOutput
        );

        return json_decode($output->fetch(), true);
    }
}
