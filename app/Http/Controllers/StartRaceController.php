<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartRacerFormRequest;
use App\Models\Clients;
use App\Models\StartDriver;
use App\Models\StartRacer;
use App\Models\StatusDriver;

class StartRaceController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/start-racer/{id}",
     * operationId="start_racer",
     * tags={"#5 - Start Racer"},
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

    /**
     * Starts checks to start a new run
     * @param Request
     * @return array
     */
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

        $status_drivers = $this->getDriver($client);
        $start_driver = $this->startDriver($request, $status_drivers);
        return response()->json($start_driver);
    }


    /**
     * Call the most suitable driver for the race
     * @param Client
     * @return array
     */
    private function getDriver($client)
    {
        $min_distance = 5; //KM

        $status_drivers = StatusDriver::select('status_driver')
            ->select('city', 'state', 'picture', 'name', 'description', 'driver_id', 'distance')
            ->join('driver', 'driver.id', '=', 'status_driver.driver_id')
            ->where('status_driver.active', '=', 1)
            ->where('driver.state', '=', $client->state)
            ->where('driver.city', '=', $client->city)
            ->where('status_driver.in_running', '=', 0)
            ->where('status_driver.distance', '<=', $min_distance)
            ->orderBy('distance')
            ->get();
        return $status_drivers;
    }

    /**
     * Saves a new ride in the bank for the driver to accept
     * @param Request $request
     * @param array $status_drivers
     * @return array
     */
    private function startDriver($request, $status_drivers)
    {
        $data = [];
        $data['client_id'] = $request->id;
        $data['from_zip_code'] = $request->from_zip_code;
        $data['to_zip_code'] = $request->to_zip_code;
        $data['status'] = 0;
        foreach ($status_drivers as $driver) {
            $data['driver_id'] = $driver->driver_id;
            $data['distance_client'] = $driver->distance;
        }

        $start_race_client_id = $this->verifyRaceClientId($data['client_id']);
        if ($start_race_client_id) {
            return [
                'message' => 'Você precisa finalizar sua corrida atual antes de iniciar uma nova!',
                'status' => 200
            ];
        }
        return StartDriver::create($data);
    }

    private function verifyRaceClientId($client_id)
    {
        return StartDriver::where('client_id', $client_id)->where('finished', '=', 1)->first();

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
