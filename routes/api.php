<?php

use App\Http\Controllers\KeluarController;
use App\Http\Controllers\MasukController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PrediksiController;
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

Route::prefix('api/v2')->group(function () {
    Route::get('/obat', [ObatController::class, 'index']);
});
 
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::prefix('api')->group(function () {
        Route::apiResources([
            'obat' => ObatController::class,
            'masuk' => MasukController::class,
            'keluar' => KeluarController::class,
            'prediksi' => PrediksiController::class,
            'pengguna' => UserController::class,
        ]);
    });
});
