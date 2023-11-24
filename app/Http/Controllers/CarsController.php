<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarsFormRequest;
use App\Models\Cars;
use App\Models\Driver;

class CarsController extends Controller
{

    private $model;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Cars $cars)
    {
        $this->model = $cars;
    }

    /**
     * @OA\get(
     *     path="/api/cars",
     *      operationId="display_cars",
     *     tags={"#3 - Car"},
     *     summary="Display all cars",
     *     description="Display all cars",
     *     @OA\Response(response="201", description="Clients registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function index()
    {
        $cars = $this->model->all();
        if (count($cars) <= 0) {
            return [
                'message' => 'Nenhum veículo foi encontrado!',
                'status' => 200
            ];
        }
        return response()->json($cars);
    }

    /**
     * @OA\Post(
     * path="/api/cars/{driver_id}",
     * operationId="register_car",
     * tags={"#3 - Car"},
     * summary="Register a new car",
     * description="Register a new car",
     *      @OA\Parameter(
     *         name="driver_id",
     *         in="path",
     *         description="Driver driver_id",
     *         required=true,
     *      ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"plate","color","year","model","name"},
     *               @OA\Property(property="plate", type="text"),
     *               @OA\Property(property="color", type="text"),
     *               @OA\Property(property="year", type="number"),
     *               @OA\Property(property="model", type="text"),
     *               @OA\Property(property="name", type="text")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Register Successfully",
     *          @OA\JsonContent(
     *              example={
     *                  {
     *                      "plate":"FAB-8575",
     *                      "color":"black",
     *                      "year": "2013",
     *                      "model": "FIAT",
     *                      "name": "BRAVO"
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
    public function store(StoreCarsFormRequest $request)
    {
        $driver = $this->validateDriver($request->id);
        if (!$driver) {
            return [
                "message" => "O motorista (" . $request->id . ") Não existe, portanto o cadastro do veículo não pode ser feito!",
                'status' => 200
            ];
        }

        if ($driver->account_validation == 0) {
            return [
                "message" => "O motorista (" . $driver->name . ") Não possui uma conta validada, somente contas validadas podem cadastrar veículos!",
                'status' => 200
            ];
        }

        $verifyCar = $this->model->where('driver_id', $request->id)->first();
        if ($verifyCar) {
            return [
                "message" => "O motorista (" . $driver->name . ")  já possui um veículo cadastrado",
                'status' => 200
            ];
        }

        $data = $request->all();
        $data['driver_id'] = $request->id;
        $cars = $this->model->create($data);
        return response()->json($cars);
    }


    /**
     * @OA\Put(
     * path="/api/cars/{id}",
     * operationId="update_car",
     * tags={"#3 - Car"},
     * summary="Update a customer",
     * description="Update a customer",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Car id",
     *         required=true,
     *      ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"plate","color", "year", "model", "name"},
     *               @OA\Property(property="plate", type="text"),
     *               @OA\Property(property="color", type="email"),
     *               @OA\Property(property="year", type="password"),
     *               @OA\Property(property="model", type="text"),
     *               @OA\Property(property="name", type="text"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Update Successfully",
     *          @OA\JsonContent(
     *              example={
     *                   {
     *                      "plate": "FAB-8575",
     *                      "color": "black",
     *                      "year": "2013",
     *                      "model": "FIAT",
     *                      "name": "BRAVO"
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
    public function update($id, StoreCarsFormRequest $request)
    {
        $car = $this->model->find($id);
        if (empty($car)) {
            return [
                'message' => 'Não foi possível atualizar os dados, o carro (' . $id . ') não existe!',
                'status' => 200
            ];
        }
        $data = $request->all();

        $data['driver_id'] = $car['driver_id'];
        $car->update($data);
        return response()->json($car);
    }


    /**
     * Get driver by id
     * @return Driver
     * @param integer $driver_id
     */
    private function validateDriver($driver_id)
    {
        $driver = new Driver();
        return $driver->find($driver_id);
    }
}
