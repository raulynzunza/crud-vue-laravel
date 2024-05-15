<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::get('/users', [UserController::class, 'getUsers'])->middleware('auth:sanctum');
Route::get('/users/{id}', [UserController::class, 'getSpecificUser'])->middleware('auth:sanctum');
Route::post('/users', [UserController::class, 'createUser']);
Route::put('/users/{id}', [UserController::class, 'updateUser'])->middleware('auth:sanctum');
Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->middleware('auth:sanctum');
