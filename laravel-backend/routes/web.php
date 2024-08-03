<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecapitulatifController;

Route::get('/', function () {
    return view('welcome');
});

 Route::post('/recapitulatifs/generate', [RecapitulatifController::class, 'generateRecapitulatifs']);

