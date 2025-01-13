<?php

namespace App\Services;
use App\Repositories\ProcessRepository;
use Illuminate\Http\Request;
use App\Repositories\ProcessValueRepository;

class ProcessValueService
{
    protected $processValueRepository;

    protected $processRepository;

    public function __construct(
        ProcessValueRepository $processValueRepository,
        ProcessRepository $processRepository
    ) {
        $this->processValueRepository = $processValueRepository;
        $this->processRepository = $processRepository;
    }

    public function search(Request $search)
    {
        return $this->processValueRepository->search($search);
    }

    public function updateValuesManual($id, $request)
    {

        $data = [
            "demand" => $request->demand,
            "provisions" => $request->provisions,
            "financial_report" => $request->financial_report,
            "updated_at" => now(),
            "user" => $request->user
        ];

        $this->processRepository->updateByAttr($request->process_id, $data);

        $update['state'] = 0;
        $update['user'] = $request->user;
        $update['deleted_at'] = now();

        $this->processValueRepository->update($id, $update);

        $create = $data;
        $create['process_id'] = $request->process_id;
        $create['year'] = $request->year;
        $create['month'] = $request->month;
        $create['state'] = 1;
        $create['user'] = $request->user;
        $create['created_at'] = now();

        return $this->processValueRepository->create($create);
    }


}
