<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'run' => ['required', 'string', 'max:255', 'unique:pgsql.BIBLIOTECA_VIRTUAL.USUARIO_PANEL'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'run.required' => 'El campo run es requerido',
            'run.string' => 'El campo run debe ser un texto',
            'run.max' => 'El campo run debe tener un máximo de 255 caracteres',
            'run.unique' => 'El campo run ya está en uso',
            'alias.required' => 'El campo nombre es requerido',
            'alias.string' => 'El campo nombre debe ser un texto',
            'alias.max' => 'El campo nombre debe tener un máximo de 255 caracteres',
            'email.required' => 'El campo correo es requerido',
            'email.string' => 'El campo correo debe ser un texto',
            'email.mail' => 'El campo correo debe ser un correo electrónico',
            'email.max' => 'El campo correo debe tener un máximo de 255 caracteres',
            'email.unique' => 'El campo correo ya está en uso',
            'password.required' => 'El campo contraseña es requerido',
            'password.string' => 'El campo contraseña debe ser un texto',
            'password.min' => 'El campo contraseña debe tener un mínimo de 8 caracteres',
            'password.confirmed' => 'El campo contraseña no coincide con la confirmación',
        ];
    }
}
