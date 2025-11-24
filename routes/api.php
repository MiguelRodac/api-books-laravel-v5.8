<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\UserController;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/ping', function () {
    $apiResponse = new class {
        use ApiResponse;
    };

    // Response for API requests
    return $apiResponse->success('API running and ready to use', 200, [
        'status' => 'OK',
        'version' => '1.0.0',
        'timestamp' => now()->toDateTimeString()
    ]);
});

/*
|--------------------------------------------------------------------------
| Public auth routes
|--------------------------------------------------------------------------
| These routes are accessible without authentication.
*/
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login',    [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Private auth routes
|--------------------------------------------------------------------------
| These routes are accessible only to authenticated users.
*/
Route::middleware('jwt.auth')->group(function () {
    Route::get('auth/me',       [AuthController::class, 'me']);
    Route::post('auth/logout',  [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    | Routes for managing users in the library system.
    */
    Route::get('users',            [UserController::class, 'index']);
    Route::get('users/{id}',       [UserController::class, 'show']);
    Route::post('users',           [UserController::class, 'store']);
    Route::put('users/{id}',       [UserController::class, 'update']);
    Route::delete('users/{id}',    [UserController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Author Routes
    |--------------------------------------------------------------------------
    | Routes for managing authors in the library system.
    */
    Route::prefix('/authors')->group(function () {
        Route::get('/', [AuthorController::class, 'index']);
        Route::get('/{id}', [AuthorController::class, 'show']);
        Route::post('/', [AuthorController::class, 'store']);
        Route::put('/{id}', [AuthorController::class, 'update']);
        Route::delete('/{id}', [AuthorController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | Book Routes
    |--------------------------------------------------------------------------
    | Routes for managing books in the library system.
    */
    Route::prefix('/books')->group(function () {
        Route::get('/', [BookController::class, 'index']);
        Route::get('/{id}', [BookController::class, 'show']);
        Route::post('/', [BookController::class, 'store']);
        Route::put('/{id}', [BookController::class, 'update']);
        Route::delete('/{id}', [BookController::class, 'destroy']);
    });
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
