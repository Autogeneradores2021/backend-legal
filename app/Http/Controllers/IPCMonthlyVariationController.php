<?php

namespace App\Http\Controllers;

use App\Services\IPCMonthlyVariationService;
use App\Utils\ResponseBuilder;
use Illuminate\Http\Request;


class IPCMonthlyVariationController extends Controller
{

    protected $response;
    protected $iPCMonthlyVariationService;

    public function __construct(ResponseBuilder $response, IPCMonthlyVariationService $iPCMonthlyVariationService)
    {
        $this->iPCMonthlyVariationService = $iPCMonthlyVariationService;
        $this->response = $response;
    }

    /**
     * @OA\Post(
     *     tags={"IPC"},
     *     path="/api/ipc-monthly-variation",
     *     summary="Calcular la variacion del IPC de todos los meses de un año",
     *      @OA\Parameter(
     *         name="x-token",
     *         in="header",
     *         description="Key API",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"year":"2024"}, summary="An result object."),
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
    public function monthlyVariation(Request $request)
    {

        try {
            $result = $this->iPCMonthlyVariationService->calculerVariation($request->year);
            return $this->response->data($result)->build();
        } catch (\Throwable $th) {
            $message = $th->getMessage() . ' - ' . $th->getLine();
            return $this->response->status(500)->message($message)->success(false)->build();
        }
    }
}
