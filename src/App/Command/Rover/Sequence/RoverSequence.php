<?php

declare(strict_types=1);

namespace Vera\Rover\App\Command\Rover\Sequence;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Vera\Rover\Domain\Rover\Model\Rover;
use Vera\Rover\Domain\Rover\Specification\RoverDirectionSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverMoveSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverPositionSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverRotateSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverSpecification;
use Vera\Rover\Domain\Rover\ValueObject\Move;
use Vera\Rover\Domain\Rover\ValueObject\Rotate;
use Symfony\Component\Console\Output\ConsoleOutput;
use Vera\Rover\Domain\Terrain\Specification\TerrainObstacleSpecification;
use Vera\Rover\Domain\Terrain\Specification\TerrainPositionSpecification;


class RoverSequence
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
    ): int {
        try {
            $roverSpec->ensurePositionIsInsideBounds($rover);
            $roverPositionSpec->ensureIsAllowedPosition($rover->position);
            $terrainPositionSpec->ensureIsAllowedPosition($rover->terrain->position);
            $terrainObstacleSpec->ensureObstaclesAreInAllowedPosition($rover);
        } catch (InvalidArgumentException $exception) {
            (new ConsoleOutput())->writeln($exception->getMessage());
            return Command::FAILURE;
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
                    (new ConsoleOutput())->writeln($exception->getMessage());
                    (new ConsoleOutput())->writeln($rover);
                    return Command::FAILURE;
                }
            }
        }

        (new ConsoleOutput())->writeln($rover);
        return Command::SUCCESS;
    }
}
