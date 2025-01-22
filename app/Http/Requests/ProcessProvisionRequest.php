<?php

namespace App\Http\Requests;

use App\Utils\ResponseBuilder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProcessProvisionRequest extends FormRequest
{
    protected $response;

    public function __construct(ResponseBuilder $response)
    {
        $this->response = $response;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'process_id' => ['required', 'integer', 'exists:processes,id'], // Valida que el ID exista en la tabla 'processes'
            'start_year' => ['required', 'integer', 'min:1900', 'max:' . (now()->year + 1)], // Año entre 1900 y el próximo año
            'start_month' => ['required', 'integer', 'between:1,12'], // Mes entre 1 y 12
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'process_id.required' => 'El campo process_id es obligatorio.',
            'process_id.integer' => 'El campo process_id debe ser un número entero.',
            'process_id.exists' => 'El process_id proporcionado no existe en la base de datos.',
            'start_year.required' => 'El campo start_year es obligatorio.',
            'start_year.integer' => 'El campo start_year debe ser un número entero.',
            'start_year.min' => 'El campo start_year debe ser un año válido a partir de 1900.',
            'start_year.max' => 'El campo start_year no puede superar el próximo año.',
            'start_month.required' => 'El campo start_month es obligatorio.',
            'start_month.integer' => 'El campo start_month debe ser un número entero.',
            'start_month.between' => 'El campo start_month debe estar entre 1 y 12.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->response->status(422)
                ->validation($validator->errors())
                ->success(false)
                ->build()
        );
    }
}
