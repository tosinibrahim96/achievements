<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\LessonUser;
use Illuminate\Database\Seeder;

class LessonUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Lesson::count() === 0) {
            $this->call(LessonSeeder::class);
        }
        
        LessonUser::factory(10)->create();
    }
}
