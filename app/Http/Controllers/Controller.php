<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="API Juridica", version="1.0 (2024-07-22)")
 *
 * @OA\Server(url="http://localhost:8081/legal/public/")
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
