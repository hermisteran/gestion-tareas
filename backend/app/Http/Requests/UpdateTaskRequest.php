<?php

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * El título de la tarea.
             *
             * @example "Generar Endpoints Editado"
             */
            'title' => 'sometimes|required|string|max:255',
            /**
             * Descripción detallada de la tarea.
             *
             * @example "Listar los endpoints disponibles."
             */
            'description' => 'sometimes|string',
            /**
             * Estado de la tarea, solo hay 3 opciones disponibles
             *
             * @example "en_progreso"
             */
            'status' => ['sometimes', new Enum(TaskStatusEnum::class)],
            /**
             * Fecha límite para completar la tarea. Formato YYYY-MM-DD.
             *
             * @example "2026-01-31"
             */
            'due_date' => 'sometimes|nullable|date|after_or_equal:today',
            /**
             * El ID de la prioridad debe existir, consultar el listado de Priority.
             *
             * @example 2
             */
            'priority_id' => 'sometimes|required|exists:priorities,id',
            /**
             * El ID de cada etiqueta debe existir, consultar el listado de Tag.
             *
             * @example [1,3]
             */
            'tags' => 'sometimes|array',
            'tags.*' => 'exists:tags,id',
        ];
    }
}
