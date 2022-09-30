<?php

use App\Http\Controllers\handlerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/sort', [handlerController::class, 'sortString']);

Route::post('/place-value', [handlerController::class, 'placeValueInNumber']);