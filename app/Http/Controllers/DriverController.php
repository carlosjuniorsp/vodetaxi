<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDriverFormRequest;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    private $model;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Driver $driver)
    {
        $this->model = $driver;
    }

    /**
     * @OA\get(
     *     path="/api/driver",
     *      operationId="display_driver",
     *     tags={"Driver"},
     *     summary="Display all customers",
     *     description="Display all customers",
     *     @OA\Response(response="201", description="driver registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function index()
    {
        $driver = $this->model->all();
        if (count($driver) <= 0) {
            return [
                'message' => 'Nenhum motorista foi encontrado!',
                'status' => 200
            ];
        }
        return response()->json($driver);
    }

    /**
     * @OA\Post(
     * path="/api/driver",
     * operationId="register_driver",
     * tags={"Driver"},
     * summary="Register a new driver",
     * description="Register a new driver",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name","email", "password", "city", "state","address","phone","age","picture","gender","description"},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="city", type="text"),
     *               @OA\Property(property="state", type="text"),
     *               @OA\Property(property="address", type="text"),
     *               @OA\Property(property="phone", type="text"),
     *               @OA\Property(property="age", type="number"),
     *               @OA\Property(property="picture", type="file"),
     *               @OA\Property(property="gender", type="text"),
     *               @OA\Property(property="description", type="text"),
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
    public function store(StoreDriverFormRequest $request)
    {
        $data = $request->all();
        $data['picture'] = $request->picture->getClientOriginalName();

        if ($request->password)
            $data['password'] = bcrypt($request->password);
        $client = $this->model->create($data);
        return response()->json($client);
    }

    /**
     * @OA\Put(
     * path="/api/driver/activation/{id}",
     * operationId="active_driver",
     * tags={"Driver"},
     * summary="Activate driver account",
     * description="Activate driver account",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Driver id",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="account_validation",
     *         in="query",
     *         description="1 active and 0 deactive",
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
    public function AccountActivation($id, Request $request)
    {

        $driver = $this->model->find($id);
        if (empty($driver)) {
            return [
                'message' => 'Não foi possível atualizar os dados, o motorista (' . $id . ') não existe!',
                'status' => 200
            ];
        }

        $driver->update($request->all());
        return response()->json($driver);
    }
}
