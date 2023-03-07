<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PositionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TokenController;


Route::get('token', [TokenController::class, 'index']);
Route::get('users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('users', [UserController::class, 'store']);
Route::get('positions', [PositionController::class, 'index']);