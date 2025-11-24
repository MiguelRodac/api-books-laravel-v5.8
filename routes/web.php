<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home Route
|--------------------------------------------------------------------------
| This route serves as the home page for the web application.
*/

Route::get('/', function () {
    $apiResponse = new class {
        use ApiResponse;
    };

    $data = [
        'message' => 'Welcome to the Web Application',
        'info' => [
            'app' => 'Library System',
            'version' => '1.0.0',
            'url' => url('/api-documentation')
        ]
    ];

    // Response for API requests
    if (request()->expectsJson()) {
        return $apiResponse->success($data['message'], 200, $data['info']);
    }

    // Response for web requests
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Catch All Undefined Routes
|--------------------------------------------------------------------------
| This route will catch all undefined routes and return a JSON response
| with a 404 status code.
*/
Route::match(['get', 'post', 'put', 'patch', 'delete'], '{any}', function ($any) {
    $apiResponse = new class {
        use ApiResponse;
    };

    $data = [
        'status' => 404,
        'error' => 'Resource Not Found',
        'message' => 'La URL solicitada no fue encontrada en este servidor',
        'path' => $any,
        'method' => request()->method(),
        'timestamp' => now()->toDateTimeString()
    ];

    // Response for API requests
    if (request()->expectsJson()) {
        return $apiResponse->error($data['message'], 404, $data['error']);
    }

    // Response for web requests
    return response()->view('errors.404', $data, 404);
})->where('any', '.*'); // Catch all routes for API and web requests
