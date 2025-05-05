<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return response()->json([
        'response_teste' => User::all()
    ]);
});

Route::post('/login', [LoginController::class, 'login']);