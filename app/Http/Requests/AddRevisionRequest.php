<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRevisionRequest extends FormRequest
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
            'estado' => 'required',
            'observacion' => 'required',
            'tecnico' => 'sometimes|required',
            'Fecha_inicio' => 'sometimes|required|date|after_or_equal:today'
        ];
    }

    public function messages(){
        return [
            'estado.required' => 'Es necesario al estado que pasará el reporte.',
            'observacion.required' => 'Es obligatorio agregar la observación de la revisión.',
            'tecnico.required' => 'El campo técnico es obligatorio.',
            'Fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'Fecha_inicio.date' => 'El campo Fecha_inicio debe ser una fecha válida.',
            'Fecha_inicio.after_or_equal' => 'La fecha de inicio no puede ser anterior a la fecha actual.',
        ];
    }
}
