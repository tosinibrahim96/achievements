<?php

namespace Tests\Unit\Listeners;

use App\Events\CommentWritten;
use App\Listeners\CommentWrittenListener;
use App\Models\Comment;
use App\Models\User;
use App\Services\Achievement\CommentWrittenAchievement;
use App\Services\User\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class CommentWrittenListenerTest extends TestCase
{

    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();
    }


    /**
     * Can listen for comment written event
     * and execute the correct listener
     */
    public function test_right_listener_called_for_comment_written_event(): void
    {
        Event::fake();

        event(new CommentWritten(Comment::factory()->create()));

        Event::assertDispatched(CommentWritten::class);
        Event::assertListening(CommentWritten::class, CommentWrittenListener::class);
    }


    /**
     * Executes the method to unlock a new achievement for a 
     * user when the user hits a new comment milestone
     */
    public function test_first_comment_achievement_unlocked_for_one_comment(): void
    {
        Event::fake();

        $comment = Comment::factory()->create();
        $event = new CommentWritten($comment);

        $user_service = Mockery::mock(UserService::class);
        $user_service->shouldReceive('userHasReachedNewMilestone')->andReturn(true);

        $comment_written_achievement = Mockery::mock(CommentWrittenAchievement::class);
        $comment_written_achievement->shouldReceive('unlockForUser')->once();

        $listener = new CommentWrittenListener($user_service, $comment_written_achievement);
        $listener->handle($event);

        $comment_written_achievement->shouldHaveReceived('unlockForUser')->once();
    }



    /**
     * Does not execute the method to unlock a new achievement
     * when the user has not reached a new comment milestone
     */
    public function test_no_achievement_unlocked_for_two_comment(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $user->comments()->saveMany(Comment::factory(2)->make());

        $event = new CommentWritten($user->comments()->first());

        $user_service = Mockery::mock(UserService::class);
        $user_service->shouldReceive('userHasReachedNewMilestone')->andReturn(false);

        $comment_written_achievement = Mockery::mock(CommentWrittenAchievement::class);
        $comment_written_achievement->shouldNotReceive('unlockForUser');

        $listener = new CommentWrittenListener($user_service, $comment_written_achievement);
        $listener->handle($event);

        $comment_written_achievement->shouldNotHaveReceived('unlockForUser');
    }
}
