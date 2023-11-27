<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateODTRequest extends FormRequest
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
            'sucursal' => 'required',
            'trabajo' => 'required',
            'tecnico' => 'required'
        ];
    }

    public function messages(){
        return [
            'sucursal.required' => 'Seleccione una sucursal para generar ODT',
            'trabajo.required' => 'Seleccione un tipo de trabajo para la ODT que está generando',
            'tecnico.required' => 'Seleccione al técnico que se le asiganará esta ODT'
        ];
    }
}
