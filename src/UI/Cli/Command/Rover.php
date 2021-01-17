<?php

namespace Vera\Rover\UI\Cli\Command;

use App\Command\Rover\Sequence\RoverSequenceHandler;
use Joselfonseca\LaravelTactician\CommandBusInterface;
use Illuminate\Console\Command;
use Vera\Rover\App\Command\Rover\Sequence\RoverSequenceCommand;

class Rover extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rover:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mars Rover CLI';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private CommandBusInterface $commandBus;
    private array $obstacles;

    public function __construct(CommandBusInterface $commandBus)
    {
        parent::__construct();
        $this->obstacles = [];
        $this->commandBus = $commandBus;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $terrainXInput = $this->ask('Terrain Size: Enter Coordinate X');
        if (!$this->assertIsInteger($terrainXInput)) {
            return Command::FAILURE;
        }
        $terrainYInput = $this->ask('Terrain Size: Enter Coordinate Y');
        if (!$this->assertIsInteger($terrainYInput)) {
            return Command::FAILURE;
        }
        $this->askObstacles();
        $coordinateXInput = $this->ask('Rover Starting point: Enter Coordinate X');
        if (!$this->assertIsInteger($coordinateXInput)) {
            return Command::FAILURE;
        }
        $coordinateYInput = $this->ask('Rover Starting point: Enter Coordinate Y');
        if (!$this->assertIsInteger($coordinateYInput)) {
            return Command::FAILURE;
        }

        $directionInput = $this->choice(
            'Rover Starting point: Enter Direction',
            ['N', 'S', 'E', 'W'],
            0
        );
        $this->line('Rover Sequence');
        $this->line('Available commands:');
        $this->table(
            ['Move Forward', 'Rotate Left', 'Rotate Right'],
            [['F', 'L', 'R']]
        );

        $sequence = $this->ask('Rover Sequence: Enter Commands (No blank spaces)');

        $this->commandBus->addHandler(RoverSequenceCommand::class, RoverSequenceHandler::class);
        $command = new RoverSequenceCommand(
            $terrainXInput,
            $terrainYInput,
            $this->obstacles,
            $coordinateXInput,
            $coordinateYInput,
            $directionInput,
            str_split($sequence)
        );

        $status = $this->commandBus->dispatch($command);
        if($status->getStatus() === 0)
        {
            $this->line($status->getErrorMessage());
        }
    }

    private function assertIsInteger($input)
    {
        if (!is_numeric($input) || $input === '' || (int)$input < 0 || is_numeric($input) && floor($input) != $input) {
            $this->line('Should be a positive integer');
            return false;
        }
        return true;
    }

    private function askObstacles()
    {
        $obstacleArrayLength = count($this->obstacles);

        if ($obstacleArrayLength === 0) {
            $response = $this->choice('Do you want to add an obstacle?', ['Yes', 'No'], 0);
        } else {
            $response = 'Yes';
        }
        if ($response === 'Yes') {
            $obstacleInputX = $this->ask('Obstacle_' . $obstacleArrayLength . ': Enter Coordinate X');
            if (!$this->assertIsInteger($obstacleInputX)) {
                return Command::FAILURE;
            }
            $obstacleInputY = $this->ask('Obstacle_' . $obstacleArrayLength . ': Enter Coordinate Y');
            if (!$this->assertIsInteger($obstacleInputY)) {
                return Command::FAILURE;
            }
            $this->obstacles[] = [$obstacleInputX, $obstacleInputY];

            $response = $this->choice('Do you want to add another obstacle?', ['Yes', 'No'], 0);
            if ($response === 'Yes') {
                $this->askObstacles();
            }
        }
    }
}
