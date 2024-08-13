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

    public function create($person)
    {
        return $this->officeRepository->create($person);
    }

    public function update($id, $process)
    {
        return $this->officeRepository->update($id, $process);
    }

    public function delete($id)
    {
        return $this->officeRepository->delete($id);
    }

}
