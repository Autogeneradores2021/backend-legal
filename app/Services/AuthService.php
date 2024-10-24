<?php
namespace App\Services;

class AuthService extends BaseApiService
{
    protected $key;

    public function __construct()
    {
        $this->baseUrl = config('app.api_login');
        $this->key = config('app.api_key_login');
    }

    public function login($user)
    {
        return $this->post('/auth/login-user', $user, ['key' => $this->key]);
    }

}
