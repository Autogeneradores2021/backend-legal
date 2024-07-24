<?php

namespace App\Repositories;

use App\Models\Action;

class ActionRepository
{

    public function all()
    {
        return Action::all();
    }
}
