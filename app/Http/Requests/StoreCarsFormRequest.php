<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarsFormRequest extends FormRequest
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
            case 'PUT':
            case 'POST': {
                    return [
                        'plate' => 'required|min:8|max:8',
                        'color' => 'required|min:3|max:50',
                        'year' => 'required|min:4|max:4',
                        'model' => 'required|min:3|max:50',
                        'name' => 'required|min:3|max:50'
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
