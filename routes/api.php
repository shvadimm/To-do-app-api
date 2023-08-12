<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TodosController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("/user/singup", [UserController::class, "singup"]);
Route::middleware('auth:api')->post('/logout', 'Auth\LoginController@logout');
Route::post("/user/login", [UserController::class, "login"]);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, "logout"]);
    Route::get('/GetAuthUser', [UserController::class, "GetAuthUser"]);
    Route::get('/todos', [TodosController::class, "index"]);
    Route::post('/todos', [TodosController::class, "store"]);
    Route::get('/todos/{id}', [TodosController::class, "show"]);
    Route::put('/todos/{id}', [TodosController::class, "update"]);
    Route::delete('/todos/{id}', [TodosController::class, "destroy"]);
});
