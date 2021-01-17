<?php

declare(strict_types=1);

namespace Vera\Rover\App\Command\Rover\Sequence;

use App\Command\Shared\CommandBusInterface;
use App\Command\Shared\CommandBusStatus;
use InvalidArgumentException;
use Vera\Rover\Domain\Rover\Model\Rover;
use Vera\Rover\Domain\Rover\Specification\RoverDirectionSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverMoveSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverPositionSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverRotateSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverSpecification;
use Vera\Rover\Domain\Rover\ValueObject\Move;
use Vera\Rover\Domain\Rover\ValueObject\Rotate;
use Vera\Rover\Domain\Terrain\Specification\TerrainObstacleSpecification;
use Vera\Rover\Domain\Terrain\Specification\TerrainPositionSpecification;


class RoverSequence implements CommandBusInterface
{

    /**
     * @param array $sequence
     * @return string
     */
    public function exec(
        Rover $rover,
        array $sequence,
        RoverDirectionSpecification $roverDirectionSpec,
        RoverMoveSpecification $roverMoveSpec,
        RoverRotateSpecification $roverRotateSpec,
        RoverPositionSpecification $roverPositionSpec,
        RoverSpecification $roverSpec,
        TerrainPositionSpecification $terrainPositionSpec,
        TerrainObstacleSpecification $terrainObstacleSpec
    ): CommandBusStatus {
        try {
            $roverSpec->ensurePositionIsInsideBounds($rover);
            $roverPositionSpec->ensureIsAllowedPosition($rover->position);
            $terrainPositionSpec->ensureIsAllowedPosition($rover->terrain->position);
            $terrainObstacleSpec->ensureObstaclesAreInAllowedPosition($rover);
        } catch (InvalidArgumentException $exception) {
            return new CommandBusStatus(0, $exception->getMessage());
        }
        foreach ($sequence as $instruction) {
            try {
                $roverDirectionSpec->ensureIsAllowedCardinatePoint($rover->getDirection());
                $roverRotateSpec->ensureIsAllowedMoveCommand(Rotate::fromString($instruction));
                $rover->rotate(Rotate::fromString($instruction));
            } catch (InvalidArgumentException $exception) {
                try {
                    $roverDirectionSpec->ensureIsAllowedCardinatePoint($rover->getDirection());
                    $roverMoveSpec->ensureIsAllowedMoveCommand(Move::fromString($instruction));
                    $roverSpec->ensureNotObstacleInFront($rover, Move::fromString($instruction));
                    $rover->move(Move::fromString($instruction));
                } catch (InvalidArgumentException $exception) {
                    return new CommandBusStatus(1, $exception->getMessage(), $rover);
                }
            }
        }

        return new CommandBusStatus(1, null, $rover);
    }

}
