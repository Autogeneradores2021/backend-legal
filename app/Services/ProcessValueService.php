<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Repositories\ProcessValueRepository;

class ProcessValueService
{
    protected $processValueRepository;

    public function __construct(ProcessValueRepository $processValueRepository)
    {
        $this->processValueRepository = $processValueRepository;
    }

    public function search(Request $search)
    {
        return $this->processValueRepository->search($search);
    }


}
