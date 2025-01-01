<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;

define('CLIENTS_ROUTE', 'clients/{id}');



// Define routes for the clients api
Route::middleware('api')->group(function () {
    Route::get('clients', [ClientController::class, 'index']);
    Route::post('clients', [ClientController::class, 'store']);
    Route::get(CLIENTS_ROUTE, [ClientController::class, 'show']);
    Route::put(CLIENTS_ROUTE, [ClientController::class, 'update']);
    Route::delete(CLIENTS_ROUTE, [ClientController::class, 'destroy']);
});
