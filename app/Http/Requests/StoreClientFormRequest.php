<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'name' => 'required|min:3|max:100',
                        'email' => 'email|required|unique:clients,email,',
                        'password' => 'required|min:8|max:15',
                        'city' => 'required|min:3|max:50',
                        'state' => 'required|min:2|max:2',
                        'address' => 'required|max:150',
                        'phone' => 'required|min:12|max:12',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'account_validation' => 'required'
                    ];
                }
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'required' => "O Campo :attribute é obrigatório",
            'email.required' => "O Campo e-mail é obrigatório",
            'email.email' => "Preencha um e-mail válido",
            'email.unique' => "O campo e-mail já está sendo usado",
            "min" => "O :attribute tem um valor mínimo de :min caractéres a ser preenchido",
            "max" => "O :attribute tem um valor máximo de :max caractéres a ser preenchido",
        ];
    }
}
