<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartRacerFormRequest extends FormRequest
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
        return [
            "from_zip_code" => "required|min:9|max:9",
            "to_zip_code" => "required|min:9|max:9",
        ];
    }

    public function messages()
    {
        return [
            'from_zip_code.required' => "Informe seu endereço de partida",
            'to_zip_code.required' => "Informe seu endereço de destino",
            "min" => "O :attribute tem um valor mínimo de :min caractéres a ser preenchido",
            "max" => "O :attribute tem um valor máximo de :max caractéres a ser preenchido",
        ];
    }
}
