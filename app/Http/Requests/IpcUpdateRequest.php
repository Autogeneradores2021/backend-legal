<?php

namespace App\Http\Requests;

use App\Utils\ResponseBuilder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class IpcUpdateRequest extends FormRequest
{

    protected $response;
    protected $validate;

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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'years' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'month' => 'required|string|max:50',
            'ipc_percentage' => 'required|numeric|min:0',
            'user_updated' => 'required|string|max:255',
        ];
    }

    /**
     * Personaliza los mensajes de error.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'years.required' => 'El campo años es obligatorio.',
            'years.digits' => 'El campo años debe tener 4 dígitos.',
            'month.required' => 'El campo mes es obligatorio.',
            'ipc_percentage.required' => 'El campo porcentaje IPC es obligatorio.',
            'ipc_percentage.numeric' => 'El campo porcentaje IPC debe ser un número.',
            'user_updated.string' => 'El campo usuario creado debe ser una cadena de texto.'
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
