<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientFormRequest;
use App\Models\Clients;
use Illuminate\Http\Request;

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
     *      operationId="display_clients",
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
     * operationId="register_client",
     * tags={"Client"},
     * summary="Register a new customer",
     * description="Register a new customer",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name","email", "password", "city", "state","address","phone"},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="city", type="text"),
     *               @OA\Property(property="state", type="text"),
     *               @OA\Property(property="address", type="text"),
     *               @OA\Property(property="phone", type="text")
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
        $data = $request->all();
        if ($request->password)
            $data['password'] = bcrypt($request->password);
        $client = $this->model->create($data);
        return response()->json($client);
    }

    /**
     * @OA\Put(
     * path="/api/clients/activation/{id}",
     * operationId="active_client",
     * tags={"Client"},
     * summary="Activate customer account",
     * description="Activate customer account",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Client id",
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
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function AccountActivation($id, Request $request)
    {

        $client = $this->model->find($id);
        if (empty($client)) {
            return [
                'message' => 'Não foi possível atualizar os dados, o cliente (' . $id . ') não existe!',
                'status' => 200
            ];
        }


        $client->update($request->all());
        return response()->json($client);
    }

    /**
     * @OA\DELETE(
     * path="/api/clients/{id}",
     * operationId="destroy_client",
     * tags={"Client"},
     * summary="Deactive customer account",
     * description="Deactive customer account",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Client id",
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
    public function destroy($id)
    {
        $client = $this->model->find($id);
        if (empty($client)) {
            return [
                'message' => 'Não foi possível deletar os dados, o cliente (' . $id . ') não existe!',
                'status' => 200
            ];
        }
        $client->delete();
        return response()->json([
            'message' => 'Os dados foram deletados com sucesso!',
            'status' => 200
        ]);
    }
}
