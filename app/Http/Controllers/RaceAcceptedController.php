<?php

namespace App\Http\Controllers;

use App\Models\StartDriver;
use Illuminate\Http\Request;

class RaceAcceptedController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/race-accepted/{id}",
     * operationId="race_accepted",
     * tags={"#6 - Racer Accepted"},
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
     * path="/api/race-accepted/{id}",
     * operationId="update_racer",
     * tags={"#6 - Racer Accepted"},
     * summary="Update a racer",
     * description="Update a racer",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Racer id",
     *         required=true,
     *      ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"running"},
     *               @OA\Property(property="running", type="number"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="1 Accepted or 0 Refused",
     *          @OA\JsonContent(
     *              example={
     *                   {
     *                      "running": 1,
     *                  }
     *              }
     *          )
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update($id)
    {
        $racer = StartDriver::find($id);
        $data['running'] = 1;
        $racer->update($data);
        return response()->json($racer);
    }
}
