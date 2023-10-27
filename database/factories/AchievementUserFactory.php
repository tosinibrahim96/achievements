<?php

namespace Database\Factories;

use App\Models\Achievement;
use App\Models\AchievementUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AchievementUserFactory extends Factory
{
    protected $model = AchievementUser::class;

    private $userId = null;

    /**
     * Specify the user for the AchievementUser record.
     *
     * @param int $userId
     * @return $this
     */
    public function withUser($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if (Achievement::count() === 0) {
            Achievement::factory()->create();
        }

        return [
            'user_id' => $this->userId ?? User::factory(),
            'achievement_id' => function () {
                $achievementIds = Achievement::pluck('id')->toArray();

                return $this->faker->randomElement($achievementIds);
            },
        ];
    }



    /**
     * Attach a first comment written achievement to
     * the user
     *
     * @return array
     */
    public function firstCommentWritten()
    {
        $achievement = Achievement::factory()->firstCommentWritten()->create();
        

        return $this->state(function (array $attributes) use ($achievement) {
            return [
                'user_id' => $this->userId ?? User::factory(),
                'achievement_id' => $achievement->id
            ];
        });
        
    }


    /**
     * Attach a first lesson watched achievement to
     * the user
     *
     * @return array
     */
    public function firstLessonWatched()
    {
        $achievement = Achievement::factory()->firstLessonWatched()->create();
        

        return $this->state(function (array $attributes) use ($achievement) {
            return [
                'user_id' => $this->userId ?? User::factory(),
                'achievement_id' => $achievement->id
            ];
        });
        
    }


    /**
     * Use the same user for all comments created
     */
    public function singleUser(): Factory
    {
        $user = User::factory()->create();

        return $this->state(function (array $attributes) use($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}
