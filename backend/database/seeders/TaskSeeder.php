<?php

namespace Database\Seeders;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $now = now();

        $statusValues = array_map(fn ($status) => $status->value, TaskStatusEnum::cases());

        for ($i = 1; $i <= 25; $i++) {

            $randomStatus = $statusValues[array_rand($statusValues)];
            $created = $now->subDays(rand(1, 60));
            Task::create([
                'title' => 'Tarea Genérica #'.$i.': '.Str::words(rand(1, 3), true),
                'description' => 'Descripción de prueba para la tarea #'.$i.'.',
                'status' => $randomStatus,
                'due_date' => $randomStatus == 'completada' ? $created : null,
                'priority_id' => rand(1, 3),
                'created_at' => $created,
                'updated_at' => $now,
            ]);
        }
    }
}
