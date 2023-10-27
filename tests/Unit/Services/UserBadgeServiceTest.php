<?php

namespace Tests\Unit\Listeners;

use App\Events\BadgeUnlocked;
use App\Models\Badge;
use App\Models\User;
use App\Services\User\UserBadgeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;

class UserBadgeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test that a new badge is created for a user when we 
     * call the unlock badge method
     * 
     */
    public function test_new_badge_created_for_user_if_not_exist(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $badge = Badge::factory()->beginner()->create();
        $user->badges()->attach($badge);

        $user_badge_service = $this->app->make(UserBadgeService::class);
        $user_badge_service->unlockBadge($user->id, $badge->id);
        
        $this->assertTrue($user->badges()->where('name', "Beginner")->exists());
    }



    /**
     * Test that the badge unlocked event is dispatched when
     * a new badge has been unlocked by a user
     * 
     */
    public function test_badge_unlocked_event_dispatched_on_badge_user_created(): void
    {
        Event::spy();

        $user = User::factory()->create();
        $badge = Badge::factory()->beginner()->create();
        $user->badges()->attach($badge);

        $user_badge_service = $this->app->make(UserBadgeService::class);
        $user_badge_service->unlockBadge($user->id, $badge->id);
        
        $this->assertTrue($user->badges()->where('name', "Beginner")->exists());
        Event::assertDispatched(BadgeUnlocked::class);
    }



    /**
     * Test that a user already has a badge true
     * 
     */
    public function test_user_already_has_badge_true(): void
    {
        $user = User::factory()->create();
        $badge = Badge::factory()->beginner()->create();
        $user->badges()->attach($badge);

        $user_badge_service = $this->app->make(UserBadgeService::class);
        
        $this->assertTrue($user_badge_service->userAlreadyHasBadge($user, $badge->id));
    }


    /**
     * Test that a user already has a badge false
     * 
     */
    public function test_user_already_has_badge_false(): void
    {
        $user = User::factory()->create();
        $badge = Badge::factory()->beginner()->create();
        $user->badges()->attach($badge);

        $intermediate_badge = Badge::factory()->intermediate()->create();
        $user_badge_service = $this->app->make(UserBadgeService::class);
        
        $this->assertFalse($user_badge_service->userAlreadyHasBadge($user, $intermediate_badge->id));
    }
}
