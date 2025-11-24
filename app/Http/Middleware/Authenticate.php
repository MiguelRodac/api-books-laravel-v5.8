<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    use ApiResponse;

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     */
    protected function unauthenticated($request, array $guards)
    {
        return $this->error('No autorizado', 401);
    }

    // /**
    //  * Get the path the user should be redirected to when they are not authenticated.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return string
    //  */
    // protected function redirectTo($request)
    // {
    //     return $this->error('No autorizado', 401);
    // }
}
