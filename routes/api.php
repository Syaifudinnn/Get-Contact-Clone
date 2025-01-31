<?php

use App\Http\Controllers\Api\AuthController;
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

Route::middleware('auth:sanctum')->get('/contacts/search', function (Request $request) {
    $query = $request->input('query');

    $contact = Contact::where('contact_name', 'LIKE', "%$query%")
        ->orWhere('contact_phone', 'LIKE', "%$query%")
        ->get();

    return response()->json(['data' => $contact]);
});

Route::post('/login', [AuthController::class, 'login']);
