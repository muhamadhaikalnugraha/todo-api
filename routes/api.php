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

    // checklist items
    Route::get('checklist/{checklistId}/items', [ChecklistItemController::class, 'index']);
    Route::post('checklist/{checklistId}/items', [ChecklistItemController::class, 'store']);
    Route::put('checklist/{checklistId}/items/{itemId}/status', [ChecklistItemController::class, 'updateStatus']);
    Route::put('/checklist/{checklistId}/items/{itemId}/rename', [ChecklistItemController::class, 'rename']);
    Route::delete('checklist/{checklistId}/items/{itemId}', [ChecklistItemController::class, 'destroy']);
});
