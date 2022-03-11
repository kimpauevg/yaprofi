<?php

use App\Http\Controllers\PromoController;
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

Route::group(['prefix' => 'promo'], function () {
    Route::get('/', [PromoController::class, 'index']);

    Route::post('/', [PromoController::class, 'store']);

    Route::group(['prefix' => '{id}'], function () {
        Route::group(['prefix' => 'participant'], function () {
            Route::post('/', [PromoController::class, 'storeParticipant']);
            Route::delete('/{participant_id}', [PromoController::class, 'deleteParticipant']);
        });

        Route::group(['prefix' => 'prize'], function () {
            Route::post('/', [PromoController::class, 'storePrize']);
            Route::delete('/{participant_id}', [PromoController::class, 'deletePrize']);
        });

        Route::post('/raffle', [PromoController::class, 'raffle']);

        Route::put('/', [PromoController::class, 'update']);

        Route::delete('/', [PromoController::class, 'delete']);

        Route::get('/', [PromoController::class, 'show']);
    });
});
