<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class BaseApiService
{

    protected $baseUrl;

    public function __construct()
    {
    }

    protected function get(string $endpoint, array $params = [])
    {
        $response = Http::get($this->baseUrl . $endpoint, $params);

        return $this->handleResponse($response);
    }

    protected function post(string $endpoint, array $data, array $headers = [])
    {
        $response = Http::withHeaders($headers)->post($this->baseUrl . $endpoint, $data);
        return $this->handleResponse($response);
    }

    protected function put(string $endpoint, array $data)
    {
        $response = Http::put($this->baseUrl . $endpoint, $data);

        return $this->handleResponse($response);
    }

    protected function delete(string $endpoint)
    {
        $response = Http::delete($this->baseUrl . $endpoint);

        return $this->handleResponse($response);
    }

    protected function handleResponse($response)
    {
        if ($response->successful()) {
            return $response->json();
        } else {
            // Manejar errores o lanzar excepciones
            throw new \Exception("Error en la solicitud HTTP: " . $response->body());
        }
    }

}
