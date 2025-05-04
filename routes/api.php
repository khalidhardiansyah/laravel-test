<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RecordLogMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource("users", UserController::class);

