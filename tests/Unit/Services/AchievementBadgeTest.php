<?php

namespace Tests\Unit\Listeners;

use App\Models\AchievementUser;
use App\Models\User;
use App\Services\Badge\AchievementBadge;
use App\Services\User\UserBadgeService;
use Database\Seeders\BadgeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AchievementBadgeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test that the user has reached new badge milestone method returns 
     * true when the person does not have any achievements
     */
    public function test_user_has_reached_new_badge_milestone_zero_achievements(): void
    {
        (new BadgeSeeder())->run();
        $user = User::factory()->create();
        
        $user_badge_service = Mockery::mock(UserBadgeService::class);
        $user_badge_service->shouldReceive('userAlreadyHasBadge');
        
        $achievement_badge = new AchievementBadge($user_badge_service);

        $result = $achievement_badge->hasReachedNewMilestone($user);
        
        $this->assertTrue($result);
    }



    /**
     * Test that the user has reached new badge milestone method returns 
     * true when the person has only one achievement
     */
    public function test_user_has_not_reached_badge_milestone_with_one_achievement(): void
    {
        (new BadgeSeeder())->run();
        
        $userAchievements = AchievementUser::factory(1)->singleUser()->create();
        $user = $userAchievements->first()->user;
        
        $user_badge_service = Mockery::mock(UserBadgeService::class);
        $user_badge_service->shouldReceive('userAlreadyHasBadge');
        
        $achievement_badge = new AchievementBadge($user_badge_service);

        $result = $achievement_badge->hasReachedNewMilestone($user);
        
        $this->assertFalse($result);
    }


    /**
     * Test that the unlockBadge does not get called when 
     * the user has not reached a new badge milestone
     * 
     */
    public function test_unlock_badge_not_called_user_has_not_reached_badge_milestone(): void
    {
        (new BadgeSeeder())->run();
        
        $userAchievements = AchievementUser::factory(1)->singleUser()->create();
        $user = $userAchievements->first()->user;

        $user_badge_service = Mockery::mock(UserBadgeService::class);
        $user_badge_service->shouldReceive('userAlreadyHasBadge');
        $user_badge_service->shouldReceive('unlockBadge');

        $achievement_badge = new AchievementBadge($user_badge_service);

        $achievement_badge->unlockForUser($user);
        
        $user_badge_service->shouldNotReceive('unlockBadge');
    }




    /**
     * Test that the unlockBadge gets called when 
     * the user has reached a new badge milestone
     * 
     */
    public function test_unlock_badge_called_user_has_reached_badge_milestone(): void
    {
        (new BadgeSeeder())->run();
        $user = User::factory()->create();

        $user_badge_service = Mockery::mock(UserBadgeService::class);
        $user_badge_service->shouldReceive('userAlreadyHasBadge');
        $user_badge_service->shouldReceive('unlockBadge');

        $achievement_badge = new AchievementBadge($user_badge_service);

        $achievement_badge->unlockForUser($user);

        $user_badge_service->shouldHaveReceived('unlockBadge')->once();
    }
}
