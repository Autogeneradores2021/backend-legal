<?php
namespace App\Services;

use App\Repositories\IPCRepository;
use App\Services\BaseService;

class IPCService extends BaseService
{

    protected $iPCRepository;

    public function __construct(IPCRepository $iPCRepository)
    {
        parent::__construct($iPCRepository);
        $this->iPCRepository = $iPCRepository;
    }

    public function search($search)
    {
        return $this->iPCRepository->search($search);
    }
}
