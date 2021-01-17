<?php

declare(strict_types=1);

namespace App\Command\Shared;

class CommandBusStatus
{
    protected int $status;
    protected ?string $message;
    protected $callback;

    public function __construct($status, $message = null, $callback = null)
    {
        $this->status = $status;
        $this->message = $message;
        $this->callback = $callback;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getCallback()
    {
        return $this->callback;
    }
}
