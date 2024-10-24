<?php

namespace App\Http\Requests;

use App\Utils\ResponseBuilder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user' => 'required|string|max:255',  // Usuario es requerido y debe ser una cadena de texto
            'password' => 'required|string|min:6', // La contraseña es requerida y debe tener al menos 6 caracteres
        ];
    }

    // Mensajes de error personalizados (opcional)
    public function messages()
    {
        return [
            'user.required' => 'El campo usuario es obligatorio.',
            'user.string' => 'El campo usuario debe ser una cadena de texto.',
            'user.max' => 'El campo usuario no puede tener más de 255 caracteres.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string' => 'El campo contraseña debe ser una cadena de texto.',
            'password.min' => 'El campo contraseña debe tener al menos 6 caracteres.',
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
