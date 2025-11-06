<?php

use App\Enums\TaskStatusEnum;
use App\Http\Controllers\Api\PriorityController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tasks', TaskController::class);
Route::apiResource('priorities', PriorityController::class)->only(['index']);
Route::apiResource('tags', TagController::class)->only(['index']);

/**
 * Estados de Tareas
 * 
 * Retorna un listado de los estados disponibles para asignar a una tarea.
 */
Route::get('statuses', function () {
    $statuses = collect(TaskStatusEnum::cases())->map(fn($status) => [
        'value' => $status->value,
        'label' => $status->name,
    ])->values();

    return response()->json($statuses);
});
