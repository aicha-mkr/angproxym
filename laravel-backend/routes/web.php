<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecapitulatifController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Middleware\ApiMiddleware;

Route::get('/', function () {
    return "test view";
});
Route::prefix('api')->middleware([ApiMiddleware::class])->group(function () {
    Route::post('/login', [AuthenticationController::class, 'login']);
});

 Route::post('/recapitulatifs/generate', [RecapitulatifController::class, 'generateRecapitulatifs']);

 
