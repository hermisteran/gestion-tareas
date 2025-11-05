<?php

namespace Database\Seeders;

use App\Enums\TaskPriorityEnum;
use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (TaskPriorityEnum::cases() as $priority) {
            Priority::create(['priority' => $priority->value]);
        }
    }
}
