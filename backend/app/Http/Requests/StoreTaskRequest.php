<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
             * @example "Generar Endpoints"
             */
            'title' => 'required|string|max:255',
            /**
             * Descripción detallada de la tarea.
             *
             * @example "Listar los endpoints disponibles"
             */
            'description' => 'required|string',
            /**
             * Fecha límite para completar la tarea. Formato YYYY-MM-DD.
             *
             * @example "2025-12-31"
             */
            'due_date' => 'nullable|date|after_or_equal:today',
            /**
             * El ID de la prioridad debe existir, consultar el listado de Priority.
             *
             * @example 1
             */
            'priority_id' => 'required|exists:priorities,id',
            /**
             * El ID de cada etiqueta debe existir, consultar el listado de Tag.
             *
             * @example [1,3]
             */
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ];
    }
}
