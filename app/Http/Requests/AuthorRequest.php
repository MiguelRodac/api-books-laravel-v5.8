<?php

namespace App\Http\Requests;

use App\Traits\ForbidsExtraFieldsTiny;
use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    use ForbidsExtraFieldsTiny;

    // Allowed extra fields
    protected array $allowedExtraFields = [
        'name',
        'email',
        'bio'
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
        $id = $this->route('id') ?? null;

        if ($id !== null) {
            // Validation to UPDATE
            return [
                'name'  => ['nullable', 'string', 'max:100'],
                'email' => [
                    'nullable',
                    'email',
                    'max:100',
                    'unique:authors,email,' . $this->route('id') // Unique validation with exception for current record when updating
                ],
                'bio'   => ['nullable', 'string'],
            ];
        }

        return [
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:authors,email'],
            'bio'   => ['nullable', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'  => 'El nombre del autor es obligatorio.',
            'name.string'    => 'El nombre debe ser una cadena de texto.',
            'name.max'       => 'El nombre no puede superar los 255 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email'    => 'Debe ser un correo electrónico válido.',
            'email.max'      => 'El correo electrónico no puede superar los 255 caracteres.',
            'email.unique'   => 'Este correo ya está registrado para otro autor.',

            'bio.string'     => 'La biografía debe ser una cadena de texto.',
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
