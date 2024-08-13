<?php

namespace App\Services;

use App\Repositories\ClassRepository;

class ClassService
{

    protected $classRepository;

    public function __construct(ClassRepository $classRepository)
    {
        $this->classRepository = $classRepository;
    }

    public function all()
    {
        return $this->classRepository->all();
    }

}
