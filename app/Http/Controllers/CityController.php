<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Utils\ResponseBuilder;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="City",
 *     description="Ciudades."
 * )
 */
class CityController extends Controller
{

    protected $response;

    public function __construct(ResponseBuilder $response)
    {

        $this->response = $response;
    }

    /**
     * @OA\Get(
     *     tags={"City"},
     *     path="/api/city",
     *     summary="Get all Cities",
     *     @OA\Parameter(
     *         name="x-token",
     *         in="header",
     *         description="Key API",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Get account user information"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="An error has occurred."
     *     )
     * )
     */
    public function index()
    {
        try {
            $result = City::all();
            return $this->response->data($result)->build();
        } catch (\Throwable $th) {
            $message = $th->getMessage() . ' - ' . $th->getLine();
            return $this->response->status(500)->message($message)->success(false)->build();
        }
    }
}
