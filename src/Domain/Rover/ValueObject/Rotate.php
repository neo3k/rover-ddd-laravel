<?php

declare(strict_types=1);

namespace Vera\Rover\Domain\Rover\ValueObject;

final class Rotate
{

    public const COMMAND_ROTATE_LEFT = 'L';
    public const COMMAND_ROTATE_RIGHT = 'R';

    private const ALLOWED_ROTATE_COMMANDS = [
        self::COMMAND_ROTATE_LEFT,
        self::COMMAND_ROTATE_RIGHT
    ];

    private $command;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public static function getAllowedRotateCommands(): array
    {
        return self::ALLOWED_ROTATE_COMMANDS;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->command;
    }
}
