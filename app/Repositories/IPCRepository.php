<?php
namespace App\Repositories;

use App\Models\Ipc;
use App\Repositories\BaseRepository;

class IPCRepository extends BaseRepository
{

    public function __construct(Ipc $model)
    {
        parent::__construct($model);
    }

    public function search($search)
    {
        $result = $this->searchQuery($search);
        return $result->paginate();
    }

}
