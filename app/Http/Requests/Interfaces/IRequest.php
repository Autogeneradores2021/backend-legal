<?php

namespace App\Http\Requests\Interfaces;

interface IRequest
{
    public function getRules(): array;
    public function getMessages(): array;
}

