<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;

class ResponseBuilder
{
    protected $success = true;
    protected $message = '';
    protected $status = 200;
    protected $data = null;

    protected $validation = null;

    public function success(bool $success): self
    {
        $this->success = $success;
        return $this;
    }

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function status(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function data($data): self
    {
        $this->data = $data;
        return $this;
    }

    public function validation($data): self
    {
        $this->validation = $data;
        return $this;
    }

    public function build(): JsonResponse
    {
        $response = [
            'success' => $this->success,
            'message' => $this->message,
            'status' => $this->status,
        ];

        if ($this->validation != null) {
            $response['validations'] = $this->validation;
        }

        if ($this->data != null) {
            $response['data'] = $this->data;
        }


        return response()->json($response, $this->status);
    }
}
