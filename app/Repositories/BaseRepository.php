<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->paginate();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function whereQuery($columns = ['id'], array $where = ["id" => 1])
    {
        $query = $this->model->select($columns);
        foreach ($where as $column => $value) {
            if (is_array($value)) {
                $operator = $value[0] ?? '=';
                $conditionValue = $value[1] ?? null;
                $query->where($column, $operator, $conditionValue);
            } else {
                $query->where($column, '=', $value);
            }
        }

        return $query;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }

    public function buildQuery($query, $key, $value)
    {
        if ($key == 'id') {
            return $query->where($key, $value);
        }
        return $query->where($key, 'like', '%' . $value . '%');
    }

    public function searchQuery($search)
    {
        return $this->model::when($search, function ($query, $search) {

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

    }
}
