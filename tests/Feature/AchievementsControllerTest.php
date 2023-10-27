<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\AchievementUser;
use App\Models\Badge;
use App\Models\User;
use Database\Seeders\AchievementSeeder;
use Database\Seeders\BadgeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AchievementsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
    }

    /**
     * Test we can get the current achievements
     */
    public function test_can_get_current_unlocked_achievement_from_endpoint(): void
    {
        (new AchievementSeeder())->run();

        $userAchievements = AchievementUser::factory(2)->singleUser()->create();
        $user = $userAchievements->first()->user;

        $response = $this->get("/users/{$user->id}/achievements");

        $body = $response->decodeResponseJson();

        $response->assertStatus(200);
        $this->assertNotEmpty($body['data']['unlocked_achievements']);
    }


    /**
     * Test we can get the next available comment
     * achievement for a user
     */
    public function test_can_get_next_available_comment_achievement_from_endpoint(): void
    {
        (new AchievementSeeder())->run();

        $userAchievement = AchievementUser::factory()->firstCommentWritten()->singleUser()->create();
        
        $user = $userAchievement->user;

        $response = $this->get("/users/{$user->id}/achievements");

        $body = $response->decodeResponseJson();

        $response->assertStatus(200);
        $response->assertJsonFragment(['unlocked_achievements' => ['First Comment Written']]);
        $this->assertTrue($body['data']['next_available_achievements'][0] == '3 Comments Written');
    }

    /**
     * Test we can get the next available comment
     * achievement for a user
     */
    public function test_can_get_next_available_lesson_watched_achievement_from_endpoint(): void
    {
        (new AchievementSeeder())->run();

        $userAchievement = AchievementUser::factory()->firstLessonWatched()->singleUser()->create();
        
        $user = $userAchievement->user;

        $response = $this->get("/users/{$user->id}/achievements");

        $body = $response->decodeResponseJson();

        $response->assertStatus(200);
        $response->assertJsonFragment(['unlocked_achievements' => ['First Lesson Watched']]);
        $this->assertTrue($body['data']['next_available_achievements'][1] == '5 Lessons Watched');
    }


     /**
     * Test we can get the current(latest) badge achieved 
     * by the user
     */
    public function test_can_get_current_user_badge_from_endpoint(): void
    {
        (new BadgeSeeder())->run();

        $user = User::factory()->create();
        $beginnerBadge = Badge::factory()->beginner()->create();
        $intermediateBadge = Badge::factory()->intermediate()->create();

        $user->badges()->attach($beginnerBadge);
        $user->badges()->attach($intermediateBadge);

        $response = $this->get("/users/{$user->id}/achievements");

        $body = $response->decodeResponseJson();

        $response->assertStatus(200);
        $response->assertJsonFragment(['current_badge' => 'Intermediate']);
    }


    /**
     * Test we can get the next badge that can be achieved 
     * by the user
     */
    public function test_can_get_next_user_badge_from_endpoint(): void
    {
        (new BadgeSeeder())->run();

        $user = User::factory()->create();
        $beginnerBadge = Badge::factory()->beginner()->create();
        $intermediateBadge = Badge::factory()->intermediate()->create();

        $user->badges()->attach($beginnerBadge);
        $user->badges()->attach($intermediateBadge);

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);
        $response->assertJsonFragment(['next_badge' => 'Advanced']);
    }



     /**
     * Test we can get the remaining achievement requried before 
     * the next badge can be unlocked
     */
    public function test_can_get_remaining_achievement_for_next_user_badge_from_endpoint(): void
    {
        (new AchievementSeeder())->run();
        (new BadgeSeeder())->run();

        $userAchievements = AchievementUser::factory(2)->singleUser()->create();
        $user = $userAchievements->first()->user;

        $beginnerBadge = Badge::factory()->beginner()->create();
        $user->badges()->attach($beginnerBadge);

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);
        $response->assertJsonFragment(['next_badge' => 'Intermediate']);
        $response->assertJsonFragment(['remaing_to_unlock_next_badge' => 2]);
    }


    /**
     * Test user has reached highest badge and achievement
     * 
     */
    public function test_user_reached_highest_badge_achievement_from_endpoint(): void
    {
        (new AchievementSeeder())->run();
        (new BadgeSeeder())->run();

        $user = User::factory()->create();

        $masterBadge = Badge::factory()->master()->create();
        $fiftyLessonWatched = Achievement::factory()->fiftyLessonsWatched()->create();
        $twentyCommentsWritten = Achievement::factory()->twentyCommentsWritten()->create();

        $user->badges()->attach($masterBadge);
        $user->achievements()->attach($fiftyLessonWatched);
        $user->achievements()->attach($twentyCommentsWritten);

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);
        $response->assertJsonFragment(['next_badge' => '']);
        $response->assertJsonFragment(['next_available_achievements' => ['','']]);
    }
}
