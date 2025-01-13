<?php

namespace App\Http\Controllers;

use App\Services\ProcessValueService;
use App\Utils\ResponseBuilder;
use Illuminate\Http\Request;


/**
 * @OA\Tag(
 *     name="Values-Process",
 *     description="Valores de los procesos legales."
 * )
 */
class ProcessValueController extends Controller
{

    protected $response;
    protected $processValueService;

    public function __construct(ResponseBuilder $response, ProcessValueService $processValueService)
    {
        $this->response = $response;
        $this->processValueService = $processValueService;
    }

    /**
     * @OA\Get(
     *     tags={"Values-Process"},
     *     path="/api/value-process",
     *     summary="Get all cost o values of process",
     *     @OA\Parameter(
     *         name="x-token",
     *         in="header",
     *         description="Key API",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *       @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="id of process",
     *         required=false,
     *         example={"id":"1"}
     *      ),
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
    public function index(Request $request)
    {
        try {

            $result = $this->processValueService->search($request);

            return $this->response->data($result)->build();

        } catch (\Throwable $th) {
            $message = $th->getMessage() . ' - ' . $th->getLine();
            return $this->response->status(500)->message($message)->success(false)->build();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
     * @OA\Put(
     *     tags={"Values-Process"},
     *     path="/api/value-process/{id}",
     *     summary="Update value process",
     *     @OA\Parameter(
     *         name="x-token",
     *         in="header",
     *         description="Key API",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"month", "process_id", "demand", "provisions", "financial_report"},
     *             @OA\Property(property="month", type="string", example="enero"),
     *             @OA\Property(property="year", type="string", example="2024"),
     *             @OA\Property(property="user", type="string", example=""),
     *             @OA\Property(property="process_id", type="integer", example=9),
     *             @OA\Property(property="demand", type="integer", example=1000),
     *             @OA\Property(property="provisions", type="integer", example=1000),
     *             @OA\Property(property="financial_report", type="integer", example=1000),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Recurso actualizado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="Process")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recurso no encontrado"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud inválida"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        try {

            $result = $this->processValueService->updateValuesManual($id, $request);

            return $this->response->data($result)->message("Valores actualizados.")->build();

        } catch (\Throwable $th) {
            $message = $th->getMessage() . ' - ' . $th->getLine();
            return $this->response->status(500)->message($message)->success(false)->build();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
