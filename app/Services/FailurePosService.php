<?php

namespace App\Services;

use App\Repositories\FailurePosRepository;

class FailurePosService
{

    protected $failurePosRepository;

    public function __construct(FailurePosRepository $failurePosRepository)
    {
        $this->failurePosRepository = $failurePosRepository;
    }

    public function all()
    {
        return $this->failurePosRepository->all();
    }

}
