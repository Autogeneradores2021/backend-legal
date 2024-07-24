<?php

namespace App\Repositories;

use App\Models\Person;


class PersonRepository
{


    public function search($search)
    {
        $result = Person::when($search, function ($query, $search) {
            return $query->where('full_name', 'like', '%' . $search . '%');
        });

        if ($search) {
            return $result->get();
        }

        return $result->paginate();
    }

    public function all()
    {
        return Person::paginate();
    }

    public function create($person)
    {
        return Person::create($person);
    }

    public function update($id, $data)
    {
        $person = Person::find($id);

        if (!$person) {
            throw new \Exception(__('messages.query.empty'), 0);
        }

        return $person->update($data);
    }

    public function delete($id)
    {
        $person = Person::findOrFail($id);
        if (!$person) {
            throw new \Exception(__('messages.query.empty'), 0);
        }
        return $person->delete();
    }


}
