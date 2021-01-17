<?php

declare(strict_types=1);

namespace App\Command\Shared;

class CommandBusStatus
{
    protected int $status;
    protected ?string $message;

    public function __construct($status, $message = null)
    {
        $this->status = $status;
        $this->message = $message;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getErrorMessage(): ?string
    {
        return $this->message;
    }
}
