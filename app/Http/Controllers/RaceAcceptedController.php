<?php

namespace App\Http\Controllers;
use App\Models\StartDriver;

class RaceAcceptedController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/race-accepted/{id}",
     * operationId="race_accepted",
     * tags={"#2 - Racer Accepted"},
     * summary="Accept a race",
     * description="Accept a race",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Driver id",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Register Successfully",
     *          @OA\JsonContent(
     *              example={
     *                  {
     *                      "account_validation": "1",
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
    public function AcceptedRacer($driver_id)
    {
        $min_distance = 10; //KM
        $accpeted_racer = StartDriver::select('start_driver')
            ->select('from_zip_code', 'to_zip_code', 'distance_client', 'name')
            ->join('clients', 'clients.id', '=', 'start_driver.client_id')
            ->where('start_driver.finished', '=', 0)
            ->where('start_driver.running', '=', 0)
            ->where('start_driver.distance_client', '<=', $min_distance)
            ->where('start_driver.driver_id', '=', $driver_id)
            ->orderBy('start_driver.id')
            ->get();
        return $accpeted_racer;
    }
}
