<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\Client;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/contacts', function () {
    $contact = Contact::all();
    return response()->json(['data' => $contact]);
});

Route::post('/login', [AuthController::class, 'login']);
