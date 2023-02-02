<?php

use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ServicoController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('pet', PetController::class);
Route::apiResource('funcionario', FuncionarioController::class);
Route::apiResource('servico', ServicoController::class);
Route::apiResource('pet', PetController::class);