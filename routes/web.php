<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/principal', [App\Http\Controllers\PrincipalController::class, 'principal']);
Route::get('/agendamentos', [App\Http\Controllers\AgendamentosController::class, 'agendamentos']);
Route::get('/marcar', [App\Http\Controllers\MarcarController::class, 'marcar']);

