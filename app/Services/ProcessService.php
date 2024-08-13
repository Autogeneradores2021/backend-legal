<?php

namespace App\Services;

use App\Repositories\ProcessRepository;


class ProcessService
{

    protected $processRepository;

    public function __construct(ProcessRepository $processRepository)
    {
        $this->processRepository = $processRepository;
    }

    public function search($search)
    {
        return $this->processRepository->search($search);
    }

    public function all()
    {
        return $this->processRepository->all();
    }

    public function create($person)
    {
        return $this->processRepository->create($person);
    }

    public function update($id, $process)
    {
        return $this->processRepository->update($id, $process);
    }

    public function delete($id)
    {
        return $this->processRepository->delete($id);
    }

}
