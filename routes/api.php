<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientsController;
use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum'])->group(function () {

    # Get detail resource
    Route::get('/patients', [PatientsController::class, 'index'])->middleware(['auth:sanctum']);

    # create/add resource
    Route::post('/patients', [PatientsController::class, 'store']);

    # update resource
    Route::put('/patients/{id}', [PatientsController::class, 'update']);

    # destroy resource
    Route::delete('/patients/{id}', [PatientsController::class, 'destroy']);

    # get detail resource by name
    Route::get('/patients/search/{name}', [PatientsController::class, 'search']);

    # get detail resource by status
    Route::get('/patients/status/{status}', [PatientsController::class, 'searchByStatus']);

    # get detail resource by id
    Route::get('/patients/{id}', [PatientsController::class, 'show']);
});

// register and login route

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);
