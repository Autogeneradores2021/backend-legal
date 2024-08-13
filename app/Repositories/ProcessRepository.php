<?php

namespace App\Repositories;

use App\Models\Process;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class ProcessRepository
{

    private function buildQuery($query, $key, $value)
    {
        if ($key == 'id') {
            return $query->where($key, $value);
        }
        return $query->where($key, 'like', '%' . $value . '%');
    }

    public function search($search)
    {

        $result = Process::when($search, function ($query, $search) {

            $data = json_decode($search, true);
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

        })
            ->with('action')
            ->with('office')
            ->with('demanding')
            ->with('defendant')
            ->with('attorney')
            ->with('classProcces')
            ->with('status')
            ->with('failurePossibility')
            ->with('city');


        return $result->paginate();
    }

    public function all()
    {
        return Process::paginate();
    }

    public function findById($id)
    {
        return Process::find($id);
    }

    public function create($process)
    {
        $result = Process::create($process);

        return Process::where('id', $result->id)
            ->with('action')
            ->with('office')
            ->with('demanding')
            ->with('defendant')
            ->with('attorney')
            ->with('classProcces')
            ->with('status')
            ->with('failurePossibility')
            ->with('city')->first();

    }

    public function update($id, $data)
    {
        $process = Process::find($id);

        if (!$process) {
            throw new \Exception(__('messages.query.empty'), 0);
        }

        $process->update($data);

        $process->refresh();

        return $process;

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
