<?php

namespace Database\Factories;

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AchievementFactory extends Factory
{
    protected $model = Achievement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'First Lesson Watched',
            'action' => 'lesson_watched',
            'action_count_required' => 1,
            'level' => 1,
        ];
    }

    /**
     * Define a state for the "First Lesson Watched" achievement.
     *
     * @return AchievementFactory
     */
    public function firstLessonWatched()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'First Lesson Watched',
                'action' => 'lesson_watched',
                'action_count_required' => 1,
                'level' => 1,
            ];
        });
    }

    /**
     * Define a state for the "5 Lessons Watched" achievement.
     *
     * @return AchievementFactory
     */
    public function fiveLessonsWatched()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => '5 Lessons Watched',
                'action' => 'lesson_watched',
                'action_count_required' => 5,
                'level' => 2,
            ];
        });
    }

    /**
     * Define a state for the "10 Lessons Watched" achievement.
     *
     * @return AchievementFactory
     */
    public function tenLessonsWatched()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => '10 Lessons Watched',
                'action' => 'lesson_watched',
                'action_count_required' => 10,
                'level' => 3,
            ];
        });
    }

    /**
     * Define a state for the "25 Lessons Watched" achievement.
     *
     * @return AchievementFactory
     */
    public function twentyFiveLessonsWatched()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => '25 Lessons Watched',
                'action' => 'lesson_watched',
                'action_count_required' => 25,
                'level' => 4,
            ];
        });
    }

    /**
     * Define a state for the "50 Lessons Watched" achievement.
     *
     * @return AchievementFactory
     */
    public function fiftyLessonsWatched()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => '50 Lessons Watched',
                'action' => 'lesson_watched',
                'action_count_required' => 50,
                'level' => 5,
            ];
        });
    }

    /**
     * Define a state for the "First Comment Written" achievement.
     *
     * @return AchievementFactory
     */
    public function firstCommentWritten()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'First Comment Written',
                'action' => 'comment_written',
                'action_count_required' => 1,
                'level' => 1,
            ];
        });
    }

    /**
     * Define a state for the "3 Comments Written" achievement.
     *
     * @return AchievementFactory
     */
    public function threeCommentsWritten()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => '3 Comments Written',
                'action' => 'comment_written',
                'action_count_required' => 3,
                'level' => 2,
            ];
        });
    }

    /**
     * Define a state for the "5 Comments Written" achievement.
     *
     * @return AchievementFactory
     */
    public function fiveCommentsWritten()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => '5 Comments Written',
                'action' => 'comment_written',
                'action_count_required' => 5,
                'level' => 3,
            ];
        });
    }

    /**
     * Define a state for the "10 Comments Written" achievement.
     *
     * @return AchievementFactory
     */
    public function tenCommentsWritten()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => '10 Comments Written',
                'action' => 'comment_written',
                'action_count_required' => 10,
                'level' => 4,
            ];
        });
    }

    /**
     * Define a state for the "20 Comments Written" achievement.
     *
     * @return AchievementFactory
     */
    public function twentyCommentsWritten()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => '20 Comments Written',
                'action' => 'comment_written',
                'action_count_required' => 20,
                'level' => 5,
            ];
        });
    }
}
