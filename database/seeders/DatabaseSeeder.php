<?php

namespace Database\Seeders;

use App\Models\Lesson;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AchievementSeeder::class,
            AchievementUserSeeder::class,
            BadgeSeeder::class,
            BadgeUserSeeder::class,
            LessonSeeder::class,
            LessonUserSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
