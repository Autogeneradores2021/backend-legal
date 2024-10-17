<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ProcessValue;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class ProcessValueRepository extends BaseRepository
{

    public function __construct(ProcessValue $model)
    {
        parent::__construct($model);
    }

    private function getKey(Request $request, $pKey)
    {
        try {
            $data = $this->buildData($request);
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $subKey => $subValue) {

                        if ($subKey == $pKey) {
                            return $subValue;
                        }
                    }
                } else {

                    if ($key == $pKey) {
                        return $value;
                    }

                }
            }
        } catch (\Throwable $th) {
            \Log::error($request);
            return $request->input('id_proceso');
        }

    }


    private function buildData(Request $request)
    {
        $page = $request->input('page');
        if (isset($page)) {
            return json_decode('{"process_id": "' . $request->input('id_proceso') . '"}', true);
        }

        return json_decode($request->search, true);
    }

    public function search(Request $request)
    {

        $result = ProcessValue::when($request, function ($query, $request) {
            $data = $this->buildData($request);
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $subKey => $subValue) {
                        $query->whereHas($key, function (EloquentBuilder $query) use ($subKey, $subValue) {
                            $this->buildQuery($query, $subKey, $subValue);
                        });
                    }
                } else {
                    $this->buildQuery($query, $key, $value);
                }
            }
        });

        return $result
            ->where('state', '<>', -1)
            ->orderBy('id', 'asc')
            ->paginate(12)
            ->appends(['id_proceso' => $this->getKey($request, 'process_id')]);

    }

    /*public function create($id, $fieldsOld, $fieldsNew)
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
    }*/



}
