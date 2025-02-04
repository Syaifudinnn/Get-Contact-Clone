<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/contacts', [ContactController::class, 'index']);
Route::middleware('auth:sanctum')->get('/searchContacts', [ContactController::class, 'search']);

Route::post('/login', [AuthController::class, 'login']);
