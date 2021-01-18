<?php

declare(strict_types=1);

namespace App\Query\Rover;

use Illuminate\Contracts\Cache\Repository;

class FindRoverByIdHandler
{

    private $roverRepository;

    public function __construct(Repository $roverRepository)
    {
        $this->roverRepository = $roverRepository;
    }

    public function handle(FindRoverById $query) {
        return $this->roverRepository->get($query->id);
    }
}
