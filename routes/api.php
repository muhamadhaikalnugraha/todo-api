<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChecklistController;
use App\Http\Controllers\Api\ChecklistItemController;
use Illuminate\Support\Facades\Route;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('auth/refresh-token', [AuthController::class, 'refreshToken']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::apiResource('checklist', ChecklistController::class)
        ->only(['index', 'store', 'destroy']);

    Route::get('checklist/{checklistId}/item', [ChecklistItemController::class, 'index']);
    Route::post('checklist/{checklistId}/item', [ChecklistItemController::class, 'store']);
    Route::put('checklist/{checklistId}/item/{itemId}/status', [ChecklistItemController::class, 'updateStatus']);
    Route::put('/checklist/{checklistId}/item/{itemId}/rename', [ChecklistItemController::class, 'rename']);
    Route::delete('checklist/{checklistId}/item/{itemId}', [ChecklistItemController::class, 'destroy']);
});
