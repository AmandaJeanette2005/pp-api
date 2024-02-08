<?php

use App\Http\Controllers\Api\PipelineController;
use App\Http\Controllers\Api\PmTypeController;
use App\Http\Controllers\Api\PmStageController;
use App\Http\Controllers\Api\PmDealController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'pipeline', "middleware" => "checkCompanyId"], function () {
    Route::get('/', [PipelineController::class, 'index']);
    Route::post('/save', [PipelineController::class, 'save']);
    Route::delete('/{id?}/delete', [PipelineController::class, 'delete']);

        Route::group(['prefix' => 'type', "middleware" => "checkCompanyId"], function () {
            Route::get('/', [PmTypeController::class, 'index']);
            Route::post('/', [PmTypeController::class, 'save']);
            Route::delete('/{id?}/delete', [PmTypeController::class, 'delete']);
        });

        Route::group(['prefix' => 'stage'], function () {
            Route::get('/', [PmStageController::class, 'index']);
            Route::post('/', [PmStageController::class, 'save']);
            Route::delete('/{id?}/delete', [PmStageController::class, 'delete']);
        });

        Route::group(['prefix' => 'deal', "middleware" => "checkCompanyId"], function () {
            Route::get('/', [PmDealController::class, 'index']);
            Route::post('/saveDeal', [PmDealController::class, 'saveDeal']);
            Route::delete('/{id?}/delete', [PmDealController::class, 'delete']);

        });

});