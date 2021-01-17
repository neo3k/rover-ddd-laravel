<?php

declare(strict_types=1);

namespace App\Query\Rover;

class FindRoverById
{

    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
