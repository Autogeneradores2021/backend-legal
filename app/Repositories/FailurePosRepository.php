<?php

namespace App\Repositories;

use App\Models\FailurePossibility;

class FailurePosRepository
{

    public function all()
    {
        return FailurePossibility::all();
    }
}
