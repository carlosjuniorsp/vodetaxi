<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusDriverRequest;
use App\Models\Cars;
use App\Models\Driver;
use App\Models\StatusDriver;

class StatusDriverController extends Controller
{
    private $model;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StatusDriver $statusDriver)
    {
        $this->model = $statusDriver;
    }

    /**
     * @OA\Post(
     * path="/api/status-driver/{id}",
     * operationId="register_status_driver",
     * tags={"#4 - Status Driver"},
     * summary="Register a status driver",
     * description="Register a status driver",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Driver id",
     *         required=true,
     *      ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"zip_code","active"},
     *               @OA\Property(property="zip_code", type="text"),
     *               @OA\Property(property="active", type="number"),
     *               @OA\Property(property="in_running", type="number"),
     *               @OA\Property(property="distance", type="number"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Register Successfully",
     *          @OA\JsonContent(
     *              example={
     *                  {
     *                      "name": "Motorista Carlos",
     *                      "email":"example@email.com.br",
     *                      "password": "12345678",
     *                      "city": "Mogi das Cruzes",
     *                      "state": "SP",
     *                      "address": "Rua 10",
     *                      "phone": "1193251-2496",
     *                      "age": 31,
     *                      "picture" : "image.jpg",
     *                      "gender": "Masculino",
     *                      "description": "Amo dirigir na vai de taxi",
     *                      "account_validation": "0"
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
    public function store($id, StoreStatusDriverRequest $request)
    {
        $driver = Driver::find($id);
        if (empty($driver)) {
            return [
                'message' => 'Motorista não encontrado, não é possível salvar sua localização!',
                'status' => 200
            ];
        }

        $driverCar = Cars::find($driver->id);
        if (empty($driverCar)) {
            return [
                'message' => 'Não é possível salvar a localização do motorista, cadastre um veículo antes!',
                'status' => 200
            ];
        }

        $data = $request->all();
        $data['driver_id'] = $driver->id;

        $verifyStatusDriver = $this->model->where('driver_id', $data['driver_id'])->first();
        if ($verifyStatusDriver) {
            $verifyStatusDriver->update($data);
            return $data;
        }
        return $this->model->create($data);
    }
}
