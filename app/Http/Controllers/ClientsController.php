<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
     *     summary="Register a new client",
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
     *     path="/api/clients",
     *      tags={"Client"},
     *     summary="Register a new client",
     *      @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Client's name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Clients's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Clients's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="Clients's city",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="state",
     *         in="query",
     *         description="Clients's state",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="adress",
     *         in="query",
     *         description="Clients's adress",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="account_validation",
     *         in="query",
     *         description="Customer account validation",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="Clients's phone",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="Clients registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function store(Request $request)
    {
        $this->validateForm($request);
        $client = $this->model->create($request->all());
        return response()->json($client);
    }


   /**
     * Validate form data
     * @param Request $request
     * @return json
     */
    private function validateForm($request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:100',
            'email' => 'required|unique:clients,email,' . $request->id,
            'phone' => 'required|min:12|max:12',
            'address' => 'required|min:3|max:100',
            'status_validation' => 'required|max:2',


        ], [
            'required' => "O :attribute é obrigatório",
            'email' => "Informe um :attribute válido",
            "min" => "O :attribute deve ter no mínimo :min caracteretes",
            "max" => "O :attribute deve ter no máximo :max caracteretes",
            "email.unique" => "Já existe um :attribute igual cadastrado, tente outro!"
        ]);
    }
}
