<?php

namespace App\Services;

use App\Repositories\ActionRepository;

class ActionService
{

    protected $actionRepository;

    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    public function all()
    {
        return $this->actionRepository->all();
    }

}
