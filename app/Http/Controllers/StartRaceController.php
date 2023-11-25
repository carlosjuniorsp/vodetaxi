<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartRacerFormRequest;
use App\Models\StartRacer;

class StartRaceController extends Controller
{
    private $model;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StartRacer $driver)
    {
        $this->model = $driver;
    }

    /**
     * @OA\Post(
     * path="/api/start-racer/{id}",
     * operationId="start_racer",
     * tags={"#4 - Start Racer"},
     * summary="Register a new racer",
     * description="Register a new racer",
     *    @OA\Parameter(
     *         name="client_id",
     *         in="path",
     *         description="Client id",
     *         required=true,
     *      ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"from_zip_code", "to_zip_code"},
     *               @OA\Property(property="from_zip_code", type="text"),
     *               @OA\Property(property="to_zip_code", type="text"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Register Successfully",
     *          @OA\JsonContent(
     *              example={
     *                  {
     *                      "from_zip_code": "08615-120",
     *                      "to_zip_code": "08615-130"
     *                  }
     *              }
     *          )
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(StartRacerFormRequest $request)
    {
       echo 'kopskdopsada';
    }

    private function verifyDriver($client){
            
    }
}
