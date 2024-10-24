<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Services\AuthService;
use App\Utils\ResponseBuilder;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Login",
 *     description="Despachos."
 * )
 */
class LoginController extends Controller
{

    protected $response;
    protected $authService;

    public function __construct(AuthService $authService, ResponseBuilder $response)
    {
        $this->authService = $authService;
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     tags={"Login"},
     *     path="/api/login",
     *     summary="Login User",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"user":"","password":""}, summary="An result object."),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description=""
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="An error has occurred."
     *     )
     * )
     */
    public function store(UserLoginRequest $request)
    {
        $user = $request->validated();

        try {
            return $this->authService->login($user);
        } catch (\Throwable $th) {
            $message = $th->getMessage() . ' - ' . $th->getLine();
            return $this->response->status(500)->message($message)->success(false)->build();
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
