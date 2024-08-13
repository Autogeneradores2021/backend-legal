<?php

namespace App\Services;

use App\Repositories\StatusRepository;



class StatusService
{

    protected $statusRepository;

    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function all()
    {
        return $this->statusRepository->all();
    }

}
