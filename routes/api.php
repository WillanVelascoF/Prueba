<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'v1', 'namespace' => 'app\Http\Controllers\Api\V1'], function () {
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/index', [UserController::class, 'index']);

    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/index', [TicketController::class, 'index']);
    Route::patch('/tickets/{id}/toggle-status', [TicketController::class, 'updateStatus']);
});
