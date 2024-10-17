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
     *     tags={"Values"},
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
