<?php

namespace Database\Seeders;

use App\Enums\TaskTagEnum;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (TaskTagEnum::cases() as $tag) {
            Tag::create(['tag' => $tag->value]);
        }
    }
}
