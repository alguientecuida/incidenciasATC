<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssingODTRequest extends FormRequest
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
            'tecnico' => 'required'
        ];
    }
    public function messages(){
        return[
            'tecnico.required' => 'Es necesario que seleccione al técnico que le asignará la ODT'
        ];
    }
}
