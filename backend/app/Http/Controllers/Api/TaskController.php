<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * @var TaskService
     */
    protected $service;

    /**
     * Inyecta el servicio de tareas.
     */
    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    /**
     * Obtener lista paginada de tareas.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $tasks = $this->service->list($request->all());

        return TaskResource::collection($tasks);
    }

    /**
     * Crea una nueva tarea.
     */
    public function store(StoreTaskRequest $request): TaskResource
    {
        $task = $this->service->create($request->validated());

        return new TaskResource($task->load(['priority', 'tags']));
    }

    /**
     * Muestra una tarea específica por ID.
     */
    public function show(Task $task): TaskResource
    {
        return new TaskResource($task->load(['priority', 'tags']));
    }

    /**
     * Actualiza una tarea existente.
     */
    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $task = $this->service->update($task, $request->validated());

        return new TaskResource($task->load(['priority', 'tags']));
    }

    /**
     * Elimina una tarea específica.
     */
    public function destroy(Task $task): Response
    {
        $this->service->delete($task);

        // Devuelve una respuesta 204 No Content
        return response()->noContent();
    }
}
