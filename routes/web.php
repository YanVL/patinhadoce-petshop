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

Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');

Route::prefix('/usuario')->group(function () {
    Route::get('/principal', [App\Http\Controllers\PrincipalController::class, 'principal'])
        ->name('app.principal');
    Route::get('/agendamentos', [App\Http\Controllers\AgendamentosController::class, 'agendamentos'])
        ->name('app.agendamentos');
    Route::get('/marcar', [App\Http\Controllers\MarcarController::class, 'marcar'])
        ->name('app.marcar');
});

Route::fallback(function() {
    echo 'A rota acessada não existe.
    <a href="'.route('app.principal').'">clique aqui</a> para ir para a página inicial.';
});
    
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
