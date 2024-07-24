<?php

namespace App\Http\Requests\Services;

use App\Http\Requests\Interfaces\IRequest;


class ProccessReqService implements IRequest
{
    public function getRules(): array
    {
        return [
            'city' => 'required|string|max:6',
            'office_id' => 'required|numeric',
            'demanding_id' => 'required|numeric',
            'defendant_id' => 'required|numeric',
            'attorney_id' => 'required|numeric',
            'niu' => 'required|string|max:255',
            'reference_internal' => 'required|string|max:255',
            'reference_external' => 'required|string|max:255',
            'facts' => 'required|string|max:255',
            'class_procces_id' => 'required|numeric',
            'action_id' => 'required|numeric',
            'status_id' => 'required|numeric',
            'failure_possibility_id' => 'required|numeric',
            'failure_possibility' => 'required',
        ];
    }

    public function getMessages(): array
    {
        return [
            'city.required' => 'La ciudad es obligatoria.',
            'city.string' => 'La ciudad debe ser una cadena de texto.',
            'city.max' => 'La ciudad no puede tener más de 6 caracteres.',
            'office_id.required' => 'El ID de la oficina es obligatorio.',
            'office_id.numeric' => 'El ID de la oficina debe ser un número.',
            'demanding_id.required' => 'El ID del demandante es obligatorio.',
            'demanding_id.numeric' => 'El ID del demandante debe ser un número.',
            'defendant_id.required' => 'El ID del demandado es obligatorio.',
            'defendant_id.numeric' => 'El ID del demandado debe ser un número.',
            'attorney_id.required' => 'El ID del abogado es obligatorio.',
            'attorney_id.numeric' => 'El ID del abogado debe ser un número.',
            'niu.required' => 'El NIU es obligatorio.',
            'niu.string' => 'El NIU debe ser una cadena de texto.',
            'niu.max' => 'El NIU no puede tener más de 255 caracteres.',
            'reference_internal.required' => 'La referencia interna es obligatoria.',
            'reference_internal.string' => 'La referencia interna debe ser una cadena de texto.',
            'reference_internal.max' => 'La referencia interna no puede tener más de 255 caracteres.',
            'reference_external.required' => 'La referencia externa es obligatoria.',
            'reference_external.string' => 'La referencia externa debe ser una cadena de texto.',
            'reference_external.max' => 'La referencia externa no puede tener más de 255 caracteres.',
            'facts.required' => 'Los hechos son obligatorios.',
            'facts.string' => 'Los hechos deben ser una cadena de texto.',
            'facts.max' => 'Los hechos no pueden tener más de 255 caracteres.',
            'class_procces_id.required' => 'El ID de la clase de proceso es obligatorio.',
            'class_procces_id.numeric' => 'El ID de la clase de proceso debe ser un número.',
            'action_id.required' => 'El ID de la acción es obligatorio.',
            'action_id.numeric' => 'El ID de la acción debe ser un número.',
            'status_id.required' => 'El ID del estado es obligatorio.',
            'status_id.numeric' => 'El ID del estado debe ser un número.',
            'failure_possibility_id.required' => 'El ID de la posibilidad de falla es obligatorio.',
            'failure_possibility_id.numeric' => 'El ID de la posibilidad de falla debe ser un número.',
            'failure_possibility.required' => 'La posibilidad de falla es obligatoria.',
        ];
    }
}
