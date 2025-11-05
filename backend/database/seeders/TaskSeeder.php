<?php

namespace Database\Seeders;

use App\Enums\TaskStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tasks')->insert([
            [
                'title' => 'Crear login',
                'description' => 'Implementar login con validación',
                'status' => TaskStatusEnum::Pendiente->value,
                'priority_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Crear Register',
                'description' => 'Crear Vistas',
                'status' => TaskStatusEnum::Iniciado->value,
                'priority_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Crear Dashboard',
                'description' => 'Crear vistas',
                'status' => TaskStatusEnum::Iniciado->value,
                'priority_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('task_tag')->insert([
            ['task_id' => 1, 'tag_id' => 1],
            ['task_id' => 2, 'tag_id' => 2],
            ['task_id' => 3, 'tag_id' => 3],
        ]);

    }
}
