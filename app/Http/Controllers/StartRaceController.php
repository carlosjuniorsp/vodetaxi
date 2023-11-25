<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartRacerFormRequest;
use App\Models\Clients;
use App\Models\StartRacer;
use App\Models\StatusDriver;

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
     *      @OA\Parameter(
     *         name="id",
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
     *                      "client_id": 1,
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
    public function StartRacer(StartRacerFormRequest $request)
    {
        return $this->verifyDriver($request);
    }

    private function verifyDriver($request)
    {
        $client = $this->verifyClient($request->id);
        if (empty($client)) {
            return [
                'message' => 'Nenhum cliente foi encontrado!',
                'status' => 200
            ];
        }

        if ($client->account_validation == 0) {
            return [
                'message' => 'Você precisa ativar sua conta antes de iniciar uma corrida!',
                'status' => 200
            ];
        }

        $min_distance = 5;

        $status_drivers = StatusDriver::select('status_driver')
            ->select('city', 'state', 'picture', 'name', 'description')
            ->join('driver', 'driver.id', '=', 'status_driver.driver_id')
            ->where('status_driver.active', '=', 1)
            ->where('driver.state', '=', $client->state)
            ->where('driver.city', '=', $client->city)
            ->where('status_driver.in_running', '=', 0)
            ->where('status_driver.distance', '<=', $min_distance)
            ->get();
        return $status_drivers;
    }

    /**
     * Get Client by id
     * @return Client
     * @param integer $client_id
     */
    private function verifyClient($client_id)
    {
        $client = new Clients();
        return $client->find($client_id);
    }
}
