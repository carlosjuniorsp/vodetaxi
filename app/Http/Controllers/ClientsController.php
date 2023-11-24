<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientFormRequest;
use App\Models\Clients;

class ClientsController extends Controller
{
    private $model;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Clients $clients)
    {
        $this->model = $clients;
    }


    /**
     * @OA\get(
     *     path="/api/clients",
     *     tags={"Client"},
     *     summary="Display all customers",
     *     description="Display all customers",
     *     @OA\Response(response="201", description="Clients registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function index()
    {
        $clients = $this->model->all();
        if (count($clients) <= 0) {
            return [
                'message' => 'Nenhum cliente foi encontrado!',
                'status' => 200
            ];
        }
        return response()->json($clients);
    }

    /**
     * @OA\Post(
     * path="/api/clients",
     * operationId="client",
     * tags={"Client"},
     * summary="Register a new customer",
     * description="Register a new customer",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name","email", "password", "city", "state","address","phone","account_validation"},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="email", type="text"),
     *               @OA\Property(property="password", type="text"),
     *               @OA\Property(property="city", type="text"),
     *               @OA\Property(property="state", type="text"),
     *               @OA\Property(property="address", type="text"),
     *               @OA\Property(property="phone", type="text"),
     *               @OA\Property(property="account_validation", type="text"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Register Successfully",
     *          @OA\JsonContent(
     *              example={
     *                  {
     *                      "name": "carlos",
     *                      "email":"example@email.com.br",
     *                      "password": "12345678",
     *                      "city": "Suzano",
     *                      "state": "SP",
     *                      "address": "Rua 01",
     *                      "phone": "1195252-8596",
     *                      "account_validation": "0"
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
    public function store(StoreClientFormRequest $request)
    {
        $client = $this->model->create($request->all());
        return response()->json($client);
    }
}
