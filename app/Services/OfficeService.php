<?php

namespace App\Services;

use App\Repositories\OfficeRepository;



class OfficeService
{

    protected $officeRepository;

    public function __construct(OfficeRepository $officeRepository)
    {
        $this->officeRepository = $officeRepository;
    }

    public function all()
    {
        return $this->officeRepository->all();
    }

}
