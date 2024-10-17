<?php

namespace App\Http\Controllers;

use App\Http\Requests\IpcStoreRequest;
use App\Http\Requests\IpcUpdateRequest;
use App\Services\IPCService;
use App\Utils\ResponseBuilder;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="IPC",
 *     description="Índice de Precios al Consumidor (IPC) - DANE."
 * )
 */
class IpcController extends Controller
{

    protected $response;

    protected $iPCService;

    public function __construct(ResponseBuilder $response, IPCService $iPCService)
    {
        $this->response = $response;
        $this->iPCService = $iPCService;
    }

    /**
     * @OA\Get(
     *     tags={"IPC"},
     *     path="/api/ipc",
     *     summary="Get all IPC or Search",
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
     *         description="",
     *         required=false,
     *         example=""
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

            $result = $this->iPCService->search($request->search);
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
     * @OA\Post(
     *     tags={"IPC"},
     *     path="/api/ipc",
     *     summary="Create IPC",
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
     *             @OA\Examples(example="result", value={"years":"2024","month":"Enero","ipc_percentage":0,"user_created":""}, summary="An result object."),
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
    public function store(IpcStoreRequest $request)
    {
        $ipc = $request->validated();

        try {
            $result = $this->iPCService->create($ipc);
            return $this->response->message(__('messages.query.insert'))->data($result)->build();
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
     * @OA\Put(
     *     tags={"IPC"},
     *     path="/api/ipc/{id}",
     *     summary="Update IPC",
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
     *             required={"years", "month", "ipc_percentage", "user_updated"},
     *             @OA\Property(property="years", type="string", maxLength=4, example="2024"),
     *             @OA\Property(property="month", type="string", maxLength=20, example="Enero"),
     *             @OA\Property(property="ipc_percentage", type="integer", example=0),
     *             @OA\Property(property="user_updated", type="string",maxLength=255, example="usuario.electrohuila"),
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
    public function update(IpcUpdateRequest $request, string $id)
    {
        $process = $request->validated();

        try {
            $result = $this->iPCService->update($id, $process);
            return $this->response->message(__('messages.query.update'))->data($result)->build();
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
