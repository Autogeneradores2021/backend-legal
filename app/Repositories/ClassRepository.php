<?php

namespace App\Repositories;

use App\Models\ClassProcces;

class ClassRepository
{
    public function all()
    {
        return ClassProcces::all();
    }
}
