<?php

namespace App\Http\Requests\Services;

use App\Http\Requests\Interfaces\IRequest;



class OfficeReqService implements IRequest
{
    public function getRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ];
    }

    public function getMessages(): array
    {
        return [
            'name.required' => 'El campo nombre completo es obligatorio.',
            'name.string' => 'El campo nombre completo debe ser una cadena de texto.',
            'name.max' => 'El campo nombre completo no debe exceder los 255 caracteres.',

            'address.required' => 'El campo apellidos es obligatorio.',
            'address.string' => 'El campo apellidos debe ser una cadena de texto.',
            'address.max' => 'El campo apellidos no debe exceder los 255 caracteres.',

        ];
    }
}
