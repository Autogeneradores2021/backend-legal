<?php

namespace App\Repositories;

use App\Models\Office;


class OfficeRepository
{

    public function all()
    {
        return Office::all();
    }
}
