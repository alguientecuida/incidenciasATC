<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReporte extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            
            'tipos' => 'required',
            'observacion' => 'required'
        ];
    }

    public function messages(){
        return [
            'tipos.required' => 'Por lo menos debe de seleccionar una falla.',
            'observacion.required' => 'La observación es obligatorio.'
        ];
    }
}
