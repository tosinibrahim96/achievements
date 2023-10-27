<?php

namespace Tests\Unit\Listeners;

use App\Events\AchievementUnlocked;
use App\Listeners\AchievementUnlockedListener;
use App\Models\Achievement;
use App\Models\AchievementUser;
use App\Models\User;
use App\Services\Badge\AchievementBadge;
use App\Services\User\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class AchievementUnlockedListenerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Can listen for achievement unlocked event
     * and execute the correct listener
     */
    public function test_right_listener_called_for_achievement_unlocked_event(): void
    {
        Event::fake();

        $achievement = Achievement::factory()->create();
        $user = User::factory()->create();

        event(new AchievementUnlocked($achievement->name, $user));

        Event::assertDispatched(AchievementUnlocked::class);
        Event::assertListening(AchievementUnlocked::class, AchievementUnlockedListener::class);
    }


    /**
     * Executes the method to unlock a new badge for a 
     * user when the user hits four achievements
     */
    public function test_unlock_badge_when_four_achievements_reached(): void
    {
        Event::fake();

        $userAchievements = AchievementUser::factory(4)->singleUser()->create();
        
        $userAchievement = $userAchievements->first();

        $event = new AchievementUnlocked($userAchievement->achievement->name, $userAchievement->user);

        $user_service = Mockery::mock(UserService::class);
        $user_service->shouldReceive('userHasReachedNewMilestone')->andReturn(true);

        $achievement_badge = Mockery::mock(AchievementBadge::class);
        $achievement_badge->shouldReceive('unlockForUser');

        $listener = new AchievementUnlockedListener($user_service, $achievement_badge);
        $listener->handle($event);

        $achievement_badge->shouldHaveReceived('unlockForUser')->once();
    }



    /**
     * Does not execute the method to unlock a new badge
     * when the user has not reached up to 4 achievements
     */
    public function test_unlock_badge_when_two_achievements_reached(): void
    {
        Event::fake();

        $userAchievements = AchievementUser::factory(2)->singleUser()->create();
        
        $userAchievement = $userAchievements->first();

        $event = new AchievementUnlocked($userAchievement->achievement->name, $userAchievement->user);

        $user_service = Mockery::mock(UserService::class);
        $user_service->shouldReceive('userHasReachedNewMilestone')->andReturn();

        $achievement_badge = Mockery::mock(AchievementBadge::class);
        $achievement_badge->shouldNotReceive('unlockForUser');

        $listener = new AchievementUnlockedListener($user_service, $achievement_badge);
        $listener->handle($event);

        $achievement_badge->shouldNotHaveReceived('unlockForUser');
    }
}
