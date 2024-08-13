<?php

namespace App\Repositories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class PersonRepository
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
        $result = Person::when($search, function ($query, $search) {
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
        });

        /*if ($search) {
            return $result->get();
        }*/

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

        $person->update($data);

        $person->refresh();

        return $person;
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
