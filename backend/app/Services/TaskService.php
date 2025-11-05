<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function list(array $filters = [])
    {
        $query = Task::with(['priority', 'tags']);

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%'.$filters['search'].'%')
                    ->orWhere('description', 'like', '%'.$filters['search'].'%');
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['priority_id'])) {
            $query->where('priority_id', $filters['priority_id']);
        }

        if (! empty($filters['tag_ids'])) {
            $tagIds = is_array($filters['tag_ids']) ? $filters['tag_ids'] : explode(',', $filters['tag_ids']);
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tags.id', $tagIds);
            });
        }

        if (! empty($filters['due_from'])) {
            $query->whereDate('due_date', '>=', $filters['due_from']);
        }

        if (! empty($filters['due_to'])) {
            $query->whereDate('due_date', '<=', $filters['due_to']);
        }

        $perPage = $filters['per_page'] ?? 15;

        return $query->orderBy('due_date')->paginate($perPage);
    }

    public function create(array $data)
    {
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $task = Task::create($data);

        if (! empty($tags)) {
            $task->tags()->sync($tags);
        }

        return $task;
    }

    public function update(Task $task, array $data)
    {
        $tags = $data['tags'] ?? null;
        unset($data['tags']);

        $task->update($data);

        if (is_array($tags)) {
            $task->tags()->sync($tags);
        }

        return $task->fresh();
    }

    public function delete(Task $task)
    {
        $task->delete();
    }
}
