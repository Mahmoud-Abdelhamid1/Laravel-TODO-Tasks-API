<?php

use App\Http\Controllers\TasksController;
use App\Http\Controllers\AuthController;
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

//public routes
Route::post('/login' , [AuthController::class , 'login']);
Route::post('/register' , [AuthController::class , 'register']);

//protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/tasks' , TasksController::class);
    Route::delete('/logout' , [AuthController::class , 'logout']);
});
Route::fallback(function(){
    return 'there is some error check url';
});
