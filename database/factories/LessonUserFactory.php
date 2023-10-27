<?php

namespace Database\Factories;


use App\Models\Lesson;
use App\Models\LessonUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonUserFactory extends Factory
{
    protected $model = LessonUser::class;

    private $userId = null;

    /**
     * Specify the user for the LessonUser record.
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
        if (Lesson::count() === 0) {
            Lesson::factory()->create();
        }

        return [
            'user_id' => $this->userId ?? User::factory(),
            'lesson_id' => function () {
                $lessonIds = Lesson::pluck('id')->toArray();

                return $this->faker->randomElement($lessonIds);
            },
            'watched' => false
        ];
    }




    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function watched()
    {
        if (Lesson::count() === 0) {
            Lesson::factory()->create();
        }

        return $this->state(function (array $attributes) {
            return [
                'user_id' => $this->userId ?? User::factory(),
                'lesson_id' => function () {
                    $lessonIds = Lesson::pluck('id')->toArray();
    
                    return $this->faker->randomElement($lessonIds);
                },
                'watched' => true
            ];
        });
        
    }



    /**
     * Use the same user for all lessons created
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
