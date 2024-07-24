<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonStoreRequest;
use App\Services\PersonService;
use App\Utils\ResponseBuilder;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Person",
 *     description="Personas."
 * )
 */
class PersonController extends Controller
{

    protected $personService;
    protected $response;

    public function __construct(ResponseBuilder $response, PersonService $personService)
    {
        $this->personService = $personService;
        $this->response = $response;
    }


    /**
     * @OA\Get(
     *     tags={"Person"},
     *     path="/api/person",
     *     summary="Get all person or Search full_name and Doc",
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
     *         description="names or doc",
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

            $result = $this->personService->search($request->search);

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
     *     tags={"Person"},
     *     path="/api/person",
     *     summary="Create Person",
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
     *             @OA\Examples(example="result", value={"full_name":"","surnames":"","type_doc":"","number_doc":""}, summary="An result object."),
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
    public function store(PersonStoreRequest $request)
    {
        $person = $request->validated();

        try {
            $result = $this->personService->create($person);
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
     *     tags={"Person"},
     *     path="/api/person/{id}",
     *     summary="Update Person",
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
     *             required={"full_name", "surnames", "type_doc", "number_doc"},
     *             @OA\Property(property="full_name", type="string", maxLength=255, example="USUARIO"),
     *             @OA\Property(property="surnames", type="string", maxLength=255, example="USUARIO"),
     *             @OA\Property(property="type_doc", type="string", maxLength=5, example="CC"),
     *             @OA\Property(property="number_doc", type="string", maxLength=20, example="1111111111"),
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
    public function update(PersonStoreRequest $request, string $id)
    {
        $person = $request->validated();

        try {
            $this->personService->update($id, $person);
            return $this->response->message(__('messages.query.update'))->build();
        } catch (\Throwable $th) {
            $message = $th->getMessage() . ' - ' . $th->getLine();
            return $this->response->status(500)->message($message)->success(false)->build();
        }
    }

    /**
     * @OA\Delete(
     *     tags={"Person"},
     *     path="/api/person/{id}",
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
            $this->personService->delete($id);
            return $this->response->message(__('messages.query.delete'))->build();
        } catch (\Throwable $th) {
            $message = $th->getMessage() . ' - ' . $th->getLine();
            return $this->response->status(500)->message($message)->success(false)->build();
        }
    }
}
