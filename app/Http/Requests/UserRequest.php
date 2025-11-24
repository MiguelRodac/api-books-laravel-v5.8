<?php

namespace App\Http\Requests;

use App\Traits\ForbidsExtraFieldsTiny;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    use ForbidsExtraFieldsTiny;

    // Allowed extra fields
    protected array $allowedExtraFields = [
        'nickname',
        'email',
        'password'
    ];

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
        // Get current user id for unique rules on update
        $id = $this->route('id');

        if ($id !== null) {
            // Validation to UPDATE
            return [
                'nickname' => [
                    'nullable',
                    'string',
                    'max:20',
                    // Unique nickname allowing same value on update
                    'unique:users,nickname,' . $id . ',id_user',
                ],
                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                    // Unique email allowing same value on update
                    'unique:users,email,' . $id . ',id_user',
                ],
            ];
        }

        return [
            // Validation to CREATE
            'nickname' => 'required|string|max:20|unique:users,nickname',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|max:16',
        ];
    }

    /**
     * Custom validation messages in Spanish.
     */
    public function messages(): array
    {
        return [
            'nickname.required' => 'El apodo es obligatorio.',
            'nickname.string'   => 'El apodo debe ser una cadena de texto.',
            'nickname.max'      => 'El apodo no puede superar los 20 caracteres.',
            'nickname.unique'   => 'Este apodo ya está registrado.',

            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Debe ser un correo electrónico válido.',
            'email.max'         => 'El correo electrónico no puede superar los 100 caracteres.',
            'email.unique'      => 'Este correo ya está registrado.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.string'   => 'La contraseña debe ser una cadena de texto.',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        $this->forbidExtraFields($this->allowedExtraFields);
    }
}
