<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ValinsApiController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/valins', [ValinsApiController::class, 'index']);
Route::post('/valins', [ValinsApiController::class, 'store']);

