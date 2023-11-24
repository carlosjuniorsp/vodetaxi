<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStatusDriverRequest extends FormRequest
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
                        'zip_code' => 'required|min:9|max:9',
                        'active' => 'required|min:1|max:1',
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
            "min" => "O :attribute tem um valor mínimo de :min caractéres a ser preenchido",
            "max" => "O :attribute tem um valor máximo de :max caractéres a ser preenchido",
        ];
    }
}
