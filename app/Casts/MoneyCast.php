<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;


class MoneyCast implements CastsAttributes
{


    public function __construct()
    {

    }

    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $formatted = number_format($value, 0, ',', '.');
        return $formatted;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        // Devuelve el valor en formato que se almacenará en la base de datos
        return $value;
    }
}
