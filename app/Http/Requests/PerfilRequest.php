<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class PerfilRequest extends FormRequest
{

    /**
     * Add parameters to be validated
     * 
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['id'] = $this->route('id');
        return $data;
    }

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
        //return [];
        switch ($this->method()) {
            case 'POST':{
                return [
                    'nombre'            => 'required|string|max:100',
                    'apellido'          => 'required|string|max:100',
                    'localidad'         => 'required|string|max:100',
                    'fecha_nacimiento'  => 'required|date',
                    'genero'            => 'required|in:Hombre,Mujer,Otros',
                    'imagen_perfil'     => 'required|mimes:jpeg,jpg,png,gif|max:10000'
                ];
            }
            case 'PUT':{
                return [
                    'nombre'            => 'string|max:100',
                    'apellido'          => 'string|max:100',
                    'localidad'         => 'string|max:100',
                    'fecha_nacimiento'  => 'date',
                    'genero'            => 'in:Hombre,Mujer,Otros',
                    'imagen_perfil'     => 'mimes:jpeg,jpg,png,gif|max:10000'
                ];
            }
            case 'PATCH':{
                return [
                    'nombre'            => 'string|max:100',
                    'apellido'          => 'string|max:100',
                    'localidad'         => 'string|max:100',
                    'fecha_nacimiento'  => 'date',
                    'genero'            => 'in:Hombre,Mujer,Otros',
                    'imagen_perfil'     => 'mimes:jpeg,jpg,png,gif|max:10000'
                ];
            }
            case 'DELETE':{
                return [
                    'id'            => 'required|exists:perfil,id'
                ];
            }
        }
    }

    public function messages()
    {
        return [
            'id.exists'                 => 'El perfil no existe',
            'nombre.required'           => 'El nombre es requerido',
            'nombre.string'             => 'El nombre debe ser string.',
            'nombre.max'                => "El nombre no debe contener más de 100 caracteres.",
            'apellido.required'         => 'El apellido es requerido',
            'apellido.string'           => 'El apellido debe ser string.',
            'apellido.max'              => "El apellido no debe contener más de 100 caracteres.",
            'localidad.required'        => 'La localidad es requerido',
            'localidad.string'          => 'La localidad debe ser string.',
            'localidad.max'             => "La localidad no debe contener más de 100 caracteres.",
            'fecha_nacimiento.date'     => "Favor de asignar una fecha válida.",
            'genero.in'                 => "el genero solo puede ser: Hombre, Mujer, Otros.",
            'imagen_perfil.required'    => 'La imagen es requerida.',
            'imagen_perfil.mimes'       => 'Solo se aceptan imagenes en formato: jpeg,jpg,png,gif.',
            'imagen_perfil.max'         => "No se permiten imagenes de más 9MB"
        ];
    }

    public function response(array $errors)
    {
        return response()->json($errors, 422);
    }


    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(['error' => $errors
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
