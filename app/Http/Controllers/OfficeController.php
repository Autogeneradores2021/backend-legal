<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfficeStoreRequest;
use App\Services\OfficeService;
use App\Utils\ResponseBuilder;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Office",
 *     description="Despachos."
 * )
 */
class OfficeController extends Controller
{

    protected $officeService;
    protected $response;


    public function __construct(OfficeService $officeService, ResponseBuilder $response)
    {
        $this->officeService = $officeService;
        $this->response = $response;
    }

    /**
     * @OA\Get(
     *     tags={"Office"},
     *     path="/api/office",
     *     summary="Get all Office",
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
            $result = $this->officeService->all();
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
     *     tags={"Office"},
     *     path="/api/office",
     *     summary="Create Office",
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
     *             @OA\Examples(example="result", value={"name":"","address":""}, summary="An result object."),
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
    public function store(OfficeStoreRequest $request)
    {
        $person = $request->validated();

        try {
            $result = $this->officeService->create($person);
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
     *     tags={"Office"},
     *     path="/api/office/{id}",
     *     summary="Update Office",
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
     *             required={"name", "address", "type_doc", "number_doc"},
     *             @OA\Property(property="name", type="string", maxLength=255, example="Office 1"),
     *             @OA\Property(property="address", type="string", maxLength=255, example="Office 1"),
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
    public function update(OfficeStoreRequest $request, string $id)
    {
        $person = $request->validated();

        try {
            $result = $this->officeService->update($id, $person);
            return $this->response->data($result)->message(__('messages.query.update'))->build();
        } catch (\Throwable $th) {
            $message = $th->getMessage() . ' - ' . $th->getLine();
            return $this->response->status(500)->message($message)->success(false)->build();
        }
    }

    /**
     * @OA\Delete(
     *     tags={"Office"},
     *     path="/api/office/{id}",
     *     summary="Delete Office",
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
     *     @OA\Response(
     *         response=200,
     *         description="Recurso actualizado con éxito",
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
    public function destroy(string $id)
    {
        try {
            $this->officeService->delete($id);
            return $this->response->message(__('messages.query.delete'))->build();
        } catch (\Throwable $th) {
            $message = $th->getMessage() . ' - ' . $th->getLine();
            return $this->response->status(500)->message($message)->success(false)->build();
        }
    }
}
