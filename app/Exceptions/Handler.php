<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler
{
    use \App\Traits\ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // Capture query exceptions
        if ($e instanceof QueryException) {
            return $this->error('Error al conectar con la base de datos', 500, $e->getMessage());
        }

        // Capture authorization exceptions
        if ($e instanceof AuthorizationException) {
            return $this->error($e->getMessage(), 403);
        }

        // Capture validation exceptions
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return $this->error($e->getMessage(), 422, $e->errors());
        }

        // Capture unauthorized exceptions
        if ($e instanceof UnauthorizedHttpException) {
            return $this->error('Token inválido o ausente', 401, $e->getMessage());
        }

        // Capture JWT exceptions
        if ($e instanceof JWTException) {
            return $this->error('Error con el token JWT', 401, $e->getMessage());
        }

        // Capture errors in general
        if (($e instanceof Exception || $e instanceof \Throwable) && !($e instanceof \Illuminate\Validation\ValidationException)) {
            // Initialize details to null and only call errors() when it's available on the object.
            $details = null;
            if (is_object($e) && method_exists($e, 'errors')) {
                /** @var mixed $e */
                $details = $e->errors();
            }
            return $this->error($e->getMessage(), 500, $details);
        }

        return parent::render($request, $e);
    }
}
