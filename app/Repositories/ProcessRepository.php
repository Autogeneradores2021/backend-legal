<?php

namespace App\Repositories;

use App\Models\Process;
use App\Services\ProcessService;


class ProcessRepository
{

    public function search($search)
    {

        $result = Process::when($search, function ($query, $search) {
            //return $query->where('full_name', 'like', '%' . $search . '%');
        });

        if ($search) {
            return $result->get();
        }

        return $result->paginate();
    }

    public function all()
    {
        return Process::paginate();
    }

    public function create($process)
    {
        return Process::create($process);
    }

    public function update($id, $data)
    {
        $process = Process::find($id);

        if (!$process) {
            throw new \Exception(__('messages.query.empty'), 0);
        }

        return $process->update($data);
    }

    public function delete($id)
    {
        $process = Process::findOrFail($id);
        if (!$process) {
            throw new \Exception(__('messages.query.empty'), 0);
        }
        $process->delete();
    }

}
