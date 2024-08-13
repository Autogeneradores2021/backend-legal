<?php

namespace App\Http\Requests\Services;

use App\Http\Requests\Interfaces\IRequest;


class PersonReqService implements IRequest
{
    public function getRules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'type_doc' => 'required|string|max:5',
            'number_doc' => 'required|string|max:20',
        ];
    }

    public function getMessages(): array
    {
        return [
            'full_name.required' => 'El campo nombre completo es obligatorio.',
            'full_name.string' => 'El campo nombre completo debe ser una cadena de texto.',
            'full_name.max' => 'El campo nombre completo no debe exceder los 255 caracteres.',

            'surnames.required' => 'El campo apellidos es obligatorio.',
            'surnames.string' => 'El campo apellidos debe ser una cadena de texto.',
            'surnames.max' => 'El campo apellidos no debe exceder los 255 caracteres.',

            'type_doc.required' => 'El campo tipo de documento es obligatorio.',
            'type_doc.string' => 'El campo tipo de documento debe ser una cadena de texto.',
            'type_doc.max' => 'El campo tipo de documento no debe exceder los 5 caracteres.',

            'number_doc.required' => 'El campo número de documento es obligatorio.',
            'number_doc.string' => 'El campo número de documento debe ser una cadena de texto.',
            'number_doc.max' => 'El campo número de documento no debe exceder los 20 caracteres.',
        ];
    }
}
