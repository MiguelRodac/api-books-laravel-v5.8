<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Devuelve una respuesta JSON exitosa
     */
    public function success(string $message = 'Operación exitosa', int $code = 200, $data = null): JsonResponse
    {
        if (!$data) {
            return response()->json([
                'success' => true,
                'message' => $message
            ], $code);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Devuelve una respuesta JSON de error
     */
    public function error(string $message = 'Error', int $code = 400, $error = null): JsonResponse
    {
        if ($error) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'error' => $error
            ], $code);
        }

        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }
}
