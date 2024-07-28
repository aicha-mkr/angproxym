<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecapitulatifController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/generate-recap/{userId}',
 [RecapitulatifController::class, 'generateRecap']);