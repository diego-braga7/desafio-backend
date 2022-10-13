<?php

use App\Http\Controllers\Api\PdvController;
use App\Http\Controllers\Api\VendaController;
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
Route::middleware('client')->group( function () {
    Route::post('pdv', [PdvController::class, 'store'])->name('pdv.store');
    Route::get('pdv/{id}', [PdvController::class, 'show'])->name('pdv.show');
    Route::get('pdv', [PdvController::class, 'index'])->name('pdv.index');
    Route::put('pdv/{id}', [PdvController::class, 'update'])->name('pdv.update');

    Route::post('venda', [VendaController::class, 'store'])->name('venda.store');
    Route::get('venda/{id}', [VendaController::class, 'show'])->name('venda.show');
    Route::get('venda', [VendaController::class, 'index'])->name('venda.index');
    Route::put('venda/{id}', [VendaController::class, 'update'])->name('venda.update');
});


