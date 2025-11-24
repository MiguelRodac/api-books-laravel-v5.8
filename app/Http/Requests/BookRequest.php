<?php

namespace App\Http\Requests;

use App\Traits\ForbidsExtraFieldsTiny;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    use ForbidsExtraFieldsTiny;

    // Allowed extra fields
    protected array $allowedExtraFields = [
        'title',
        'description',
        'id_author',
        'published_at',
        'available'
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
                'title'        => 'nullable|string|max:255|unique:books,title,' . $id . ',id_book',
                'description'  => 'nullable|string',
                'id_author'    => [
                    'nullable',
                    'integer',
                    Rule::exists('authors', 'id_author'),
                ],
                'published_at' => 'nullable|date',
                'available'    => 'nullable|boolean',
            ];
        }

        // Validation to CREATE
        return [
            'title'        => 'required|string|max:255|unique:books,title',
            'description'  => 'required|string',
            'id_author'    => 'required|integer|exists:authors,id_author',
            'published_at' => 'required|date',
            'available'    => 'required|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required'       => 'El título es obligatorio.',
            'title.string'         => 'El título debe ser texto.',
            'title.max'            => 'El título no debe exceder 255 caracteres.',
            'id_author.required'      => 'El autor es obligatorio.',
            'id_author.integer'       => 'El autor debe ser un número entero.',
            'id_author.exists'        => 'El autor seleccionado no existe.',
            'published_at.date'    => 'La fecha de publicación debe ser válida.',
            'available.boolean'    => 'El campo disponible debe ser verdadero o falso.',
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
