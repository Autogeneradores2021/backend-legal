<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessStoreRequest;
use App\Services\ProcessService;
use App\Utils\ResponseBuilder;
use Illuminate\Http\Request;

use OpenApi\Annotations as OA;
use App\Swagger\Process;

/**
 * @OA\Tag(
 *     name="Legal-Process",
 *     description="Procesos legales."
 * )
 */
class ProcessController extends Controller
{

    protected $response;
    protected $processService;

    public function __construct(ResponseBuilder $response, ProcessService $processService)
    {
        $this->response = $response;
        $this->processService = $processService;
    }

    /**
     * @OA\Get(
     *     tags={"Legal-Process"},
     *     path="/api/legal-process",
     *     summary="Get all process or Search",
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

            $result = $this->processService->search($request->search);

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
     *     tags={"Legal-Process"},
     *     path="/api/legal-process",
     *     summary="Create Process",
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
     *             @OA\Examples(example="result", value={"city":"123456","office_id":1,"demanding_id":1,"defendant_id":1,"attorney_id":2,"niu":"123","reference_internal":"123","reference_external":"123","facts":"123","class_procces_id":1,"action_id":1,"status_id":1,"failure_possibility_id":1,"failure_possibility":1}, summary="An result object."),
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
    public function store(ProcessStoreRequest $request)
    {
        $process = $request->validated();

        try {
            $result = $this->processService->create($process);
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
     *     tags={"Legal-Process"},
     *     path="/api/legal-process/{id}",
     *     summary="Update Process",
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
     *             required={"city", "office_id", "demanding_id", "defendant_id", "attorney_id", "niu", "reference_internal", "reference_external", "facts", "class_procces_id", "action_id", "status_id", "failure_possibility_id", "failure_possibility"},
     *             @OA\Property(property="city", type="string", maxLength=6, example="NY"),
     *             @OA\Property(property="office_id", type="integer", example=1),
     *             @OA\Property(property="demanding_id", type="integer", example=1),
     *             @OA\Property(property="defendant_id", type="integer", example=1),
     *             @OA\Property(property="attorney_id", type="integer", example=1),
     *             @OA\Property(property="niu", type="string", maxLength=255, example="123456"),
     *             @OA\Property(property="reference_internal", type="string", maxLength=255, example="internal_ref"),
     *             @OA\Property(property="reference_external", type="string", maxLength=255, example="external_ref"),
     *             @OA\Property(property="facts", type="string", maxLength=255, example="Some facts"),
     *             @OA\Property(property="class_procces_id", type="integer", example=1),
     *             @OA\Property(property="action_id", type="integer", example=1),
     *             @OA\Property(property="status_id", type="integer", example=1),
     *             @OA\Property(property="failure_possibility_id", type="integer", example=1),
     *             @OA\Property(property="failure_possibility", type="string", example="1"),
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
    public function update(ProcessStoreRequest $request, string $id)
    {
        $process = $request->validated();

        try {
            $result = $this->processService->update($id, $process);
            return $this->response->message(__('messages.query.update'))->data($result)->build();
        } catch (\Throwable $th) {
            $message = $th->getMessage() . ' - ' . $th->getLine();
            return $this->response->status(500)->message($message)->success(false)->build();
        }
    }

    /**
     * @OA\Delete(
     *     tags={"Legal-Process"},
     *     path="/api/legal-process/{id}",
     *     summary="Delete Process",
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
            $this->processService->delete($id);
            return $this->response->message(__('messages.query.delete'))->build();
        } catch (\Throwable $th) {
            $message = $th->getMessage() . ' - ' . $th->getLine();
            return $this->response->status(500)->message($message)->success(false)->build();
        }
    }
}
