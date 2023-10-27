<?php

namespace Tests\Unit\Listeners;

use App\Models\Achievement;
use App\Models\User;
use App\Services\User\UserAchievementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;

class UserAchievementServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test that a new achievement is created for a user when we 
     * call the unlockAchievement method
     * 
     */
    public function test_new_achievement_created_for_user_if_not_exist(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $achievement = Achievement::factory()->firstLessonWatched()->create();
        $user->achievements()->attach($achievement);

        $user_achievement_service = $this->app->make(UserAchievementService::class);
        $user_achievement_service->unlockAchievement($user->id, $achievement->id);
        
        $this->assertTrue($user->achievements()->where('name', "First Lesson Watched")->exists());
    }



    /**
     * Test that the achievement unlocked event is dispatched when
     * a new achievement has been unlocked by a user
     * 
     */
    public function test_achievement_unlocked_event_dispatched_on_achievement_user_created(): void
    {
        Event::spy();

        $user = User::factory()->create();
        $achievement = Achievement::factory()->fiveLessonsWatched()->create();
        $user->achievements()->attach($achievement);

        $user_achievement_service = $this->app->make(UserAchievementService::class);
        $user_achievement_service->unlockAchievement($user->id, $achievement->id);
        
        $this->assertTrue($user->achievements()->where('name', "5 Lessons Watched")->exists());
        Event::assertDispatched(AchievementUnlocked::class);
    }



    /**
     * Test that a user already has a achievement true
     * 
     */
    public function test_user_already_has_achievement_true(): void
    {
        $user = User::factory()->create();
        $achievement = Achievement::factory()->firstLessonWatched()->create();
        $user->achievements()->attach($achievement);

        $user_achievement_service = $this->app->make(UserAchievementService::class);
        
        $this->assertTrue($user_achievement_service->userAlreadyHasAchievement($user, $achievement->id));
    }


    /**
     * Test that a user already has a achievement false
     * 
     */
    public function test_user_already_has_achievement_false(): void
    {
        $user = User::factory()->create();
        $achievement = Achievement::factory()->firstLessonWatched()->create();
        $user->achievements()->attach($achievement);

        $unachieved_achievement = Achievement::factory()->fiveLessonsWatched()->create();
        $user_achievement_service = $this->app->make(UserAchievementService::class);
        
        $this->assertFalse($user_achievement_service->userAlreadyHasAchievement($user, $unachieved_achievement->id));
    }
}
