<?php

namespace App\Http\Controllers;

use App\Services\ActionService;
use App\Services\ClassService;
use App\Services\FailurePosService;
use App\Services\OfficeService;
use App\Services\StatusService;
use App\Utils\ResponseBuilder;

/**
 * @OA\Tag(
 *     name="Common",
 *     description="comunes."
 * )
 */
class ParameterController extends Controller
{

    protected $actionService;
    protected $officeService;

    protected $failurePosService;
    protected $response;

    protected $classService;

    protected $statusService;

    public function __construct(
        ResponseBuilder $response,
        ActionService $actionService,
        OfficeService $officeService,
        FailurePosService $failurePosService,
        ClassService $classService,
        StatusService $statusService,

    ) {
        $this->response = $response;
        $this->actionService = $actionService;
        $this->officeService = $officeService;
        $this->failurePosService = $failurePosService;
        $this->classService = $classService;
        $this->statusService = $statusService;
    }

    /**
     * @OA\Get(
     *     tags={"Common"},
     *     path="/api/common",
     *     summary="Get actions,offices and failures",
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

            $actions = $this->actionService->all();
            $offices = $this->officeService->all();
            $failures = $this->failurePosService->all();
            $class = $this->classService->all();
            $status = $this->statusService->all();

            $data = [
                'actions' => $actions,
                'offices' => $offices,
                'failures' => $failures,
                'class' => $class,
                'status' => $status,
            ];

            return $this->response->data($data)->build();

        } catch (\Throwable $th) {
            $message = $th->getMessage() . ' - ' . $th->getLine();
            return $this->response->status(500)->message($message)->success(false)->build();
        }
    }
}
