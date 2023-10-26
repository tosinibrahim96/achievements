<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Achievement::factory()->firstLessonWatched()->create();
        Achievement::factory()->fiveLessonsWatched()->create();
        Achievement::factory()->tenLessonsWatched()->create();
        Achievement::factory()->twentyFiveLessonsWatched()->create();
        Achievement::factory()->fiftyLessonsWatched()->create();
        Achievement::factory()->firstCommentWritten()->create();
        Achievement::factory()->threeCommentsWritten()->create();
        Achievement::factory()->fiveCommentsWritten()->create();
        Achievement::factory()->tenCommentsWritten()->create();
        Achievement::factory()->twentyCommentsWritten()->create();
    }
}
