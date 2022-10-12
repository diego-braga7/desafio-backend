<?php

use App\Http\Controllers\Api\PdvController;
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
});

Route::get('/greeting', function () {
    return 'Hello World';
});
