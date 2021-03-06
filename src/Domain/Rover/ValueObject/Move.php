<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Rover\ValueObject;

class Move
{

    public const COMMAND_MOVE = 'F';

    public const MOVEMENT_FACTOR = 1;

    private const ALLOWED_MOVE_COMMANDS = [
        self::COMMAND_MOVE,
    ];

    private $command;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public static function fromString(string $command): self
    {
        return new self($command);
    }

    public static function getAllowedMoveCommands(): array
    {
        return self::ALLOWED_MOVE_COMMANDS;
    }

    /**
     * @param int $value
     * @return int
     */
    public function factor(int $value): int
    {
        return (self::MOVEMENT_FACTOR * $value);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->command;
    }
}
