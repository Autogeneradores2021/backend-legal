<?php

namespace App\Services;

use App\Repositories\PersonRepository;


class PersonService
{

    protected $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function search($search)
    {
        return $this->personRepository->search($search);
    }

    public function all()
    {
        return $this->personRepository->all();
    }

    public function create($person)
    {
        return $this->personRepository->create($person);
    }

    public function update($id, $process)
    {
        return $this->personRepository->update($id, $process);
    }

    public function delete($id)
    {
        return $this->personRepository->delete($id);
    }


}
