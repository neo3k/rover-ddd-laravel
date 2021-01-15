<?php

declare(strict_types=1);

namespace App\Command\Rover\Sequence;


use Domain\Rover\Specification\RoverSpecification;
use Vera\Rover\App\Command\Rover\Sequence\RoverSequence;
use Vera\Rover\App\Command\Rover\Sequence\RoverSequenceCommand;
use Vera\Rover\Domain\Rover\Specification\RoverDirectionSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverMoveSpecification;
use Vera\Rover\Domain\Rover\Specification\RoverRotateSpecification;

class RoverSequenceHandler
{

    private RoverDirectionSpecification $roverDirectionSpec;
    private RoverMoveSpecification $roverMoveSpec;
    private RoverRotateSpecification $roverRotateSpec;
    private RoverSpecification $roverSpec;

    public function __construct(
        RoverDirectionSpecification $roverDirectionSpec,
        RoverMoveSpecification $roverMoveSpec,
        RoverRotateSpecification $roverRotateSpec,
        RoverSpecification $roverSpec
    ) {
        $this->roverDirectionSpec = $roverDirectionSpec;
        $this->roverMoveSpec = $roverMoveSpec;
        $this->roverRotateSpec = $roverRotateSpec;
        $this->roverSpec = $roverSpec;
    }

    public function handle(RoverSequenceCommand $command): int
    {
        return (new RoverSequence())->exec(
            $command->rover,
            $command->sequence,
            $this->roverDirectionSpec,
            $this->roverMoveSpec,
            $this->roverRotateSpec,
            $this->roverSpec
        );

    }
}
