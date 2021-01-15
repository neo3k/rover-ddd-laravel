<?php

namespace App\Console\Commands;

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

    public function __construct(CommandBusInterface $commandBus)
    {
        parent::__construct();

        $this->commandBus = $commandBus;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('Mars Rover CLI');
        $this->newLine();
        $coordinateXInput = $this->ask('Rover Starting point: Enter Coordinate X');
        if (!is_numeric($coordinateXInput) || $coordinateXInput === '') {
            $coordinateXInput = $this->ask('Rover Starting point: Enter Coordinate X (Should be a number)');
        }
        $coordinateYInput = $this->ask('Rover Starting point: Enter Coordinate Y');
        if (!is_numeric($coordinateYInput) || $coordinateYInput === '') {
            $coordinateYInput = $this->ask('Rover Starting point: Enter Coordinate Y (Should be a number)');
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
            $coordinateXInput,
            $coordinateYInput,
            $directionInput,
            str_split($sequence)
        );
        $this->commandBus->dispatch($command);

    }
}
