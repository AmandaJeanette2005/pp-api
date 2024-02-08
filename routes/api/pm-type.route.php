<?php

use App\Http\Controllers\Api\PmTypeController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'type', "middleware" => "checkCompanyId"], function () {
    Route::get('/', [PmTypeController::class, 'index']);
    Route::post('/', [PmTypeController::class, 'save']);
    Route::delete('/{id?}/delete', [PmTypeController::class, 'delete']);
});