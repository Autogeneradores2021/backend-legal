<?php

namespace App\Http\Requests;

use App\Http\Requests\Services\PersonReqService;
use App\Utils\ResponseBuilder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PersonStoreRequest extends FormRequest
{

    protected $response;
    protected $validate;

    public function __construct(ResponseBuilder $response, PersonReqService $validate)
    {
        $this->response = $response;
        $this->validate = $validate;
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
        return $this->validate->getRules();
    }

    public function messages()
    {
        return $this->validate->getMessages();
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
