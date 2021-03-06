<?php

declare(strict_types=1);

namespace App\Command\Rover\Sequence;


use App\Command\Shared\CommandBusHandlerInterface;
use App\Command\Shared\CommandBusStatus;
use Illuminate\Cache\Repository;
use Vera\Rover\App\Command\Rover\Sequence\RoverSequence;
use Vera\Rover\App\Command\Rover\Sequence\RoverSequenceCommand;
use Vera\Rover\Domain\Rover\Specification\RoverDirectionSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverMoveSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverPositionSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverRotateSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverSpecification;
use Vera\Rover\Domain\Terrain\Specification\TerrainObstacleSpecification;
use Vera\Rover\Domain\Terrain\Specification\TerrainPositionSpecification;

class RoverSequenceHandler implements CommandBusHandlerInterface
{

    private RoverDirectionSpecification $roverDirectionSpec;
    private RoverMoveSpecification $roverMoveSpec;
    private RoverRotateSpecification $roverRotateSpec;
    private RoverSpecification $roverSpec;
    private TerrainPositionSpecification $terrainPositionSpec;
    private TerrainObstacleSpecification $terrainObstacleSpec;
    private RoverPositionSpecification $roverPositionSpec;
    private Repository $roverRepository;

    /**
     * @var RoverPositionSpecification
     */

    public function __construct(
        RoverDirectionSpecification $roverDirectionSpec,
        RoverMoveSpecification $roverMoveSpec,
        RoverRotateSpecification $roverRotateSpec,
        RoverPositionSpecification $roverPositionSpec,
        RoverSpecification $roverSpec,
        TerrainPositionSpecification $terrainPositionSpec,
        TerrainObstacleSpecification $terrainObstacleSpec,
        Repository $roverRepository
    ) {
        $this->roverDirectionSpec = $roverDirectionSpec;
        $this->roverMoveSpec = $roverMoveSpec;
        $this->roverRotateSpec = $roverRotateSpec;
        $this->roverPositionSpec = $roverPositionSpec;
        $this->roverSpec = $roverSpec;
        $this->terrainPositionSpec = $terrainPositionSpec;
        $this->terrainObstacleSpec = $terrainObstacleSpec;
        $this->roverRepository = $roverRepository;
    }

    public function handle(RoverSequenceCommand $command): CommandBusStatus
    {
        $exec = (new RoverSequence())->exec(
            $command->rover,
            $command->sequence,
            $this->roverDirectionSpec,
            $this->roverMoveSpec,
            $this->roverRotateSpec,
            $this->roverPositionSpec,
            $this->roverSpec,
            $this->terrainPositionSpec,
            $this->terrainObstacleSpec
        );

        if($exec->getCallback()){
            $this->roverRepository->put($exec->getCallback()->getId(), $exec->getCallback());
        }

        return $exec;

    }
}
