<?php

namespace Database\Factories;


use App\Models\Badge;
use App\Models\BadgeUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BadgeUserFactory extends Factory
{
    protected $model = BadgeUser::class;

    private $userId = null;

    /**
     * Specify the user for the BadgeUser record.
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
        if (Badge::count() === 0) {
            Badge::factory()->create();
        }

        return [
            'user_id' => $this->userId ?? User::factory(),
            'badge_id' => function () {
                $badgeIds = Badge::pluck('id')->toArray();

                return $this->faker->randomElement($badgeIds);
            },
        ];
    }


    /**
     * Assign a beginner badge to a user
     *
     * @return array
     */
    public function beginner()
    {
        $badge = Badge::factory()->beginner()->create();
        

        return $this->state(function (array $attributes) use ($badge) {
            return [
                'user_id' => $this->userId ?? User::factory(),
                'badge_id' => $badge->id
            ];
        });
        
    }

    /**
     * Assign a intermediate badge to a user
     *
     * @return array
     */
    public function intermediate()
    {
        $badge = Badge::factory()->intermediate()->create();
        
        return $this->state(function (array $attributes) use ($badge) {
            return [
                'user_id' => $this->userId ?? User::factory(),
                'badge_id' => $badge->id
            ];
        });
        
    }


    /**
     * Use the same user for all badges created
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
