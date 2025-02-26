<?php

use App\Filament\Resources\UserResource\Api\Handlers\UpdateHandler;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'userProfile']);
Route::middleware('auth:sanctum')->put('/user/update-visibility', [UserController::class, 'updateUserVisibility']);
Route::middleware('auth:sanctum')->put('/user/update-spam-protection', [UserController::class, 'updateSpamProtection']);

Route::middleware('auth:sanctum')->get('/contacts', [ContactController::class, 'index']);
Route::middleware('auth:sanctum')->get('/searchContacts', [ContactController::class, 'search']);

Route::post('/login', [AuthController::class, 'login']);
