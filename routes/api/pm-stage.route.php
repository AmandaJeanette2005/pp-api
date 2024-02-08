<?php

use App\Http\Controllers\Api\PmStageController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'stage'], function () {
    Route::get('/', [PmStageController::class, 'index']);
    Route::post('/', [PmStageController::class, 'save']);
    Route::delete('/{id?}/delete', [PmStageController::class, 'delete']);
});