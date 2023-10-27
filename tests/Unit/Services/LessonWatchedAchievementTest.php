<?php

namespace Tests\Unit\Listeners;

use App\Models\LessonUser;
use App\Services\Achievement\LessonWatchedAchievement;
use App\Services\User\UserAchievementService;
use Database\Seeders\AchievementSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class LessonWatchedAchievementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test that the user has reached new milestone method returns 
     * true when the person watches up to 5 lessons
     */
    public function test_user_has_reached_new_milestone_with_five_lessons_watched(): void
    {
        (new AchievementSeeder())->run();

        $userWatchedLessons = LessonUser::factory(5)->watched()->singleUser()->create();
        $user = $userWatchedLessons->first()->user;
        
        $user_achievement_service = Mockery::mock(UserAchievementService::class);
        $user_achievement_service->shouldReceive('userAlreadyHasAchievement');
        
        $lesson_watched_achivement = new LessonWatchedAchievement($user_achievement_service);

        $result = $lesson_watched_achivement->hasReachedNewMilestone($user);
        
        $this->assertTrue($result);
    }



    /**
     * Test that the user has not reached a new milestone method returns 
     * false when the user has not watched any lessons at all
     */
    public function test_user_has_not_reached_new_milestone_with_no_lessons_watched(): void
    {
        (new AchievementSeeder())->run();

        $userLessons = LessonUser::factory(1)->singleUser()->create();
        $user = $userLessons->first()->user;
        
        $user_achievement_service = Mockery::mock(UserAchievementService::class);
        $user_achievement_service->shouldReceive('userAlreadyHasAchievement');
        
        $lesson_watched_achivement = new LessonWatchedAchievement($user_achievement_service);

        $result = $lesson_watched_achivement->hasReachedNewMilestone($user);
        
        $this->assertFalse($result);
    }



    /**
     * Test that the unlockAchievement does not get called when 
     * the user has not reached a milestone for lessons
     * watched
     * 
     */
    public function test_unlock_achievement_not_called_user_has_not_reached_new_milestone(): void
    {
        (new AchievementSeeder())->run();

        $userLessons = LessonUser::factory(1)->singleUser()->create();
        $user = $userLessons->first()->user;

        $user_achievement_service = Mockery::mock(UserAchievementService::class);
        $user_achievement_service->shouldReceive('userAlreadyHasAchievement');
        $user_achievement_service->shouldReceive('unlockAchievement');

        $lesson_watched_achivement = new LessonWatchedAchievement($user_achievement_service);

        $lesson_watched_achivement->unlockForUser($user);
        
        $user_achievement_service->shouldNotReceive('unlockAchievement');
    }




    /**
     * Test that the unlockAchievement gets called when 
     * the user has reached a new milestone for lessons watched
     * 
     */
    public function test_unlock_achievement_called_user_has_reached_new_milestone(): void
    {
        (new AchievementSeeder())->run();

        $userWatchedLessons = LessonUser::factory(5)->watched()->singleUser()->create();
        $user = $userWatchedLessons->first()->user;

        $user_achievement_service = Mockery::mock(UserAchievementService::class);
        $user_achievement_service->shouldReceive('userAlreadyHasAchievement');
        $user_achievement_service->shouldReceive('unlockAchievement');

        $lesson_watched_achivement = new LessonWatchedAchievement($user_achievement_service);

        $lesson_watched_achivement->unlockForUser($user);

        $user_achievement_service->shouldHaveReceived('unlockAchievement')->once();
    }

}
