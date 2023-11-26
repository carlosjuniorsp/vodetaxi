<?php

namespace App\Http\Controllers;

use App\Http\Requests\RaceAcceptedFormRequest;
use App\Models\StartDriver;

class RaceAcceptedController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/race-accepted/{id}",
     * operationId="race_accepted",
     * tags={"#6 - Race Accepted"},
     * summary="Accept a race",
     * description="Accept a race",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Driver id",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function AcceptedRacer($driver_id)
    {
        $min_distance = 10; //KM
        $accpeted_racer = StartDriver::select('start_driver')
            ->select('start_driver.id', 'from_zip_code', 'to_zip_code', 'distance_client', 'name')
            ->join('clients', 'clients.id', '=', 'start_driver.client_id')
            ->where('start_driver.finished', '=', 0)
            ->where('start_driver.running', '=', 0)
            ->where('start_driver.distance_client', '<=', $min_distance)
            ->where('start_driver.driver_id', '=', $driver_id)
            ->orderBy('start_driver.id')
            ->get();
        return $accpeted_racer;
    }

    /**
     * @OA\Put(
     * path="/api/race-accepted/{id}/{running}",
     * operationId="update_racer",
     * tags={"#6 - Race Accepted"},
     * summary="Update a racer",
     * description="Update a racer",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Racer id",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="running",
     *         in="path",
     *         description="1 accepted or 0 refused",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update($id, $running)
    {
        $racer = StartDriver::find($id);
        if (!$racer) {
            return [
                'message' => 'Está corrida não existe mais!',
                'status' => 200
            ];
        }
        $data['running'] = $running;
        $racer->update($data);
        return response()->json($racer);
    }

    /**
     * @OA\Put(
     * path="/api/race-finished/{id}/{finished}",
     * operationId="finished_race",
     * tags={"#7 - Race Finished"},
     * summary="Finished a race",
     * description="Finished a race",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Racer id",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="finished",
     *         in="path",
     *         description="1 finishes the race",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function FinishedRacer($id, $finished)
    {

        $racer = StartDriver::find($id);
        if (!$racer) {
            return [
                'message' => 'Está corrida não existe mais!',
                'status' => 200
            ];
        }

        if ($racer->finished == 1) {
            return [
                'message' => 'Está corrida ja foi finalizada!',
                'status' => 200
            ];
        }
        $data['finished'] = $finished;
        $racer->update($data);
        return response()->json($racer);
    }
}
