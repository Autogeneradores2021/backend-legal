<?php

namespace App\Repositories;

use App\Models\Office;


class OfficeRepository
{

    public function all()
    {
        return Office::paginate();
    }

    public function create($person)
    {
        return Office::create($person);
    }

    public function update($id, $data)
    {
        $office = Office::find($id);

        if (!$office) {
            throw new \Exception(__('messages.query.empty'), 0);
        }

        $office->update($data);

        $office->refresh();

        return $office;
    }

    public function delete($id)
    {
        $office = Office::findOrFail($id);
        if (!$office) {
            throw new \Exception(__('messages.query.empty'), 0);
        }
        return $office->delete();
    }
}
