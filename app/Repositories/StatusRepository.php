<?php

namespace App\Repositories;

use App\Models\Status;


class StatusRepository
{

    public function all()
    {
        return Status::all();
    }
}
