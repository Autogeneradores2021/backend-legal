<?php

namespace App\Repositories;

use App\Models\ProcessValue;


class ProcessValueRepository
{
    protected $processRepository;

    public function __construct(ProcessRepository $processRepository)
    {
        $this->processRepository = $processRepository;
    }

    public function create($id, $fieldsOld, $fieldsNew)
    {

        $create = false;
        foreach ($fieldsNew as $field => $newValue) {
            if ($fieldsOld[$field] != $newValue) {
                $create = true;
                break;
            }
        }

        if ($create) {
            $data = array_merge(
                ['process_id' => $id, 'state' => 1],
                $fieldsNew
            );

            ProcessValue::where('process_id', $id)
                ->where('state', 1)->update(['state' => 0]);

            ProcessValue::create($data);

        }
    }



}
