<?php

namespace Database\Factories;

use App\Models\Badge;
use Illuminate\Database\Eloquent\Factories\Factory;

class BadgeFactory extends Factory
{
    protected $model = Badge::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Beginner',
            'achievement_count_required' => 0,
            'level' => 1
        ];
    }

    /**
     * Define a state for the "Beginner" badge.
     *
     * @return BadgeFactory
     */
    public function beginner()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Beginner',
                'achievement_count_required' => 0,
                'level' => 1,
            ];
        });
    }

    /**
     * Define a state for the "Intermediate" badge.
     *
     * @return BadgeFactory
     */
    public function intermediate()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Intermediate',
                'achievement_count_required' => 4,
                'level' => 2,
            ];
        });
    }

    /**
     * Define a state for the "Advanced" badge.
     *
     * @return BadgeFactory
     */
    public function advanced()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Advanced',
                'achievement_count_required' => 8,
                'level' => 3,
            ];
        });
    }

    /**
     * Define a state for the "Master" badge.
     *
     * @return BadgeFactory
     */
    public function master()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Master',
                'achievement_count_required' => 10,
                'level' => 4,
            ];
        });
    }
}
