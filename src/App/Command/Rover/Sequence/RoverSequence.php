<?php

declare(strict_types=1);

namespace Vera\Rover\App\Command\Rover\Sequence;

use InvalidArgumentException;
use Vera\Rover\Domain\Rover\Model\Rover;
use Vera\Rover\Domain\Rover\Specification\RoverDirectionSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverMoveSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverRotateSpecification;
use Vera\Rover\Domain\Rover\ValueObject\Move;
use Vera\Rover\Domain\Rover\ValueObject\Rotate;


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
        RoverRotateSpecification $roverRotateSpec
    ) {
        foreach ($sequence as $instruction) {
            try {
                $roverDirectionSpec->ensureIsAllowedCardinatePoint($rover->getDirection());
                $roverRotateSpec->ensureIsAllowedMoveCommand($instruction);
                $rover->rotate(new Rotate($instruction));
            } catch (InvalidArgumentException $exception) {
                try {
                    $roverDirectionSpec->ensureIsAllowedCardinatePoint($rover->getDirection());
                    $roverMoveSpec->ensureIsAllowedMoveCommand($instruction);
                    $rover->move(new Move($instruction));
                } catch (InvalidArgumentException $exception) {
                    throw new InvalidArgumentException('Operation is not executable');
                }
            }
        }

        return $rover;
    }
}
