<?php

namespace Tests\Feature;

use App\Models\Priority;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_tasks()
    {
        Priority::factory()->create(['priority' => 'MEDIA']);
        Tag::factory()->count(2)->create();
        Task::factory()->count(5)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_can_create_task()
    {
        $priority = Priority::factory()->create();
        $tags = Tag::factory()->count(2)->create();

        $payload = [
            'title' => 'Test task',
            'description' => 'desc',
            'status' => 'pendiente',
            'due_date' => now()->addWeek()->toDateString(),
            'priority_id' => $priority->id,
            'tags' => $tags->pluck('id')->toArray(),
        ];

        $response = $this->postJson('/api/tasks', $payload);
        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'Test task')
            ->assertJsonPath('data.priority.id', $priority->id);
    }

    public function test_can_update_task()
    {
        $task = Task::factory()->create();
        $response = $this->putJson("/api/tasks/{$task->id}", ['title' => 'Updated']);
        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated');
    }

    public function test_can_delete_task()
    {
        $task = Task::factory()->create();
        $response = $this->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(204);
        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }
}
