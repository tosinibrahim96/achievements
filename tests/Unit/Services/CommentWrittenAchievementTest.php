<?php

namespace Tests\Unit\Listeners;

use App\Models\Comment;
use App\Models\User;
use App\Services\Achievement\CommentWrittenAchievement;
use App\Services\User\UserAchievementService;
use Database\Seeders\AchievementSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class CommentWrittenAchievementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test that the user has reached new milestone method returns 
     * true when the person makes their first comment
     */
    public function test_user_has_reached_new_milestone_with_first_comment(): void
    {
        (new AchievementSeeder())->run();

        $user = User::factory()->create();
        $user->comments()->saveMany(Comment::factory(1)->make());

        $user_achievement_service = Mockery::mock(UserAchievementService::class);
        $user_achievement_service->shouldReceive('userAlreadyHasAchievement');
        
        $comment_written_achivement = new CommentWrittenAchievement($user_achievement_service);

        $result = $comment_written_achivement->hasReachedNewMilestone($user);
        
        $this->assertTrue($result);
    }



    /**
     * Test that the user has not reached a new milestone method returns 
     * false when the user does not have any comments at all
     */
    public function test_user_has_not_reached_new_milestone_with_no_comment(): void
    {
        (new AchievementSeeder())->run();

        $user = User::factory()->create();

        $user_achievement_service = Mockery::mock(UserAchievementService::class);
        $user_achievement_service->shouldReceive('userAlreadyHasAchievement');
        
        $comment_written_achivement = new CommentWrittenAchievement($user_achievement_service);

        $result = $comment_written_achivement->hasReachedNewMilestone($user);
        
        $this->assertFalse($result);
    }


     /**
     * Test that the user has not reached a new milestone method returns 
     * false when there are no achievements in the system to compare with
     */
    public function test_user_has_not_reached_new_milestone_with_no_achievements_in_db(): void
    {
        $user = User::factory()->create();
        $user->comments()->saveMany(Comment::factory(1)->make());

        $user_achievement_service = Mockery::mock(UserAchievementService::class);
        $user_achievement_service->shouldReceive('userAlreadyHasAchievement');
        
        $comment_written_achivement = new CommentWrittenAchievement($user_achievement_service);

        $result = $comment_written_achivement->hasReachedNewMilestone($user);
        
        $this->assertFalse($result);
    }
}
