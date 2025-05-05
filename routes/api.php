<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return response()->json([
        'response_teste' => User::all()
    ]);
});

Route::post('auth/login', [LoginController::class, 'login']);
Route::post('auth/register', [LoginController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [LoginController::class, 'logout']);

    Route::get('authors', [AuthorController::class, 'index']);
    Route::get('authors/{id}', [AuthorController::class, 'show']);
    Route::post('authors', [AuthorController::class, 'store']);
    Route::put('authors/{id}', [AuthorController::class, 'update']);
    Route::delete('authors/{id}', [AuthorController::class, 'destroy']);

    Route::get('books', [BookController::class, 'index']);
    Route::get('books/{id}', [BookController::class, 'show']);
    Route::post('books', [BookController::class, 'store']);
    Route::put('books/{id}', [BookController::class, 'update']);
    Route::delete('books/{id}', [BookController::class, 'destroy']);

});