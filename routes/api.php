<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/clients', function () {
    $clients = Client::all();
    return response()->json(['data' => $clients]);
});

Route::post('/login', [AuthController::class, 'login']);
