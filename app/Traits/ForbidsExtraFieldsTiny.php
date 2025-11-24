<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

trait ForbidsExtraFieldsTiny
{
    /**
     * Comprueba keys top-level del payload contra $allowed.
     *
     * Uso:
     * - Definir protected array $allowedBodyFields = [...]; en el FormRequest
     * - O llamar $this->forbidExtraFields(['a','b']) desde passedValidation()
     */
    protected function forbidExtraFields(array $overrideAllowed): void
    {
        $allowed = $overrideAllowed
            ?? (property_exists($this, 'allowedBodyFields') ? (array) $this->allowedBodyFields : [])
            ?? [];

        // permitir metadatos comunes si los necesitás (override en FormRequest)
        $extrasAllowed = property_exists($this, 'allowedBodyExtras') ? (array) $this->allowedBodyExtras : ['_method'];

        $allowed = array_values(array_unique(array_merge($allowed, $extrasAllowed)));

        $payloadKeys = array_keys($this->all());
        $notAllowed = array_values(array_diff($payloadKeys, $allowed));

        if (! empty($notAllowed)) {
            $data = [
                'status'  => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Fields are not allowed',
                'fields'  => $notAllowed,
            ];

            throw new HttpResponseException(response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY));
        }
    }

    /**
     * Summary of validatedIdRequest
     * @param mixed $id
     * @return \Illuminate\Validation\Validator
     */
    public function validatedIdRequest($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|min:1',
        ]);

        return $validator;
    }
}
