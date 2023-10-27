<?php

namespace Tests\Unit\Listeners;

use App\Events\LessonWatched;
use App\Listeners\LessonWatchedListener;
use App\Models\Lesson;
use App\Models\LessonUser;
use App\Models\User;
use App\Services\Achievement\LessonWatchedAchievement;
use App\Services\User\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class LessonWatchedListenerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Can listen for lesson watched event
     * and execute the correct listener
     */
    public function test_right_listener_called_for_lesson_watched_event(): void
    {
        Event::fake();

        $lesson = Lesson::factory()->create();
        $user = User::factory()->create();

        event(new LessonWatched($lesson, $user));

        Event::assertDispatched(LessonWatched::class);
        Event::assertListening(LessonWatched::class, LessonWatchedListener::class);
    }


    /**
     * Executes the method to unlock a new achievement for a 
     * user when the user hits a new lesson watched milestone
     */
    public function test_unlock_achievement_when_five_lessons_watched(): void
    {
        Event::fake();

        $userWatchedLessons = LessonUser::factory(5)->watched()->singleUser()->create();
        
        $userLesson = $userWatchedLessons->first();

        $event = new LessonWatched($userLesson->lesson, $userLesson->user);

        $user_service = Mockery::mock(UserService::class);
        $user_service->shouldReceive('userHasReachedNewMilestone')->andReturn(true);

        $lesson_watched_achievement = Mockery::mock(LessonWatchedAchievement::class);
        $lesson_watched_achievement->shouldReceive('unlockForUser')->once();

        $listener = new LessonWatchedListener($user_service, $lesson_watched_achievement);
        $listener->handle($event);

        $lesson_watched_achievement->shouldHaveReceived('unlockForUser')->once();
    }



    /**
     * Does not execute the method to unlock a new achievement
     * when the user has not reached a new comment milestone
     */
    public function test_unlock_achievement_when_two_lessons_watched(): void
    {
        Event::fake();

        $userWatchedLessons = LessonUser::factory(2)->watched()->singleUser()->create();
        
        $userLesson = $userWatchedLessons->first();

        $event = new LessonWatched($userLesson->lesson, $userLesson->user);

        $user_service = Mockery::mock(UserService::class);
        $user_service->shouldReceive('userHasReachedNewMilestone')->andReturn(false);

        $lesson_watched_achievement = Mockery::mock(LessonWatchedAchievement::class);
        $lesson_watched_achievement->shouldNotReceive('unlockForUser');

        $listener = new LessonWatchedListener($user_service, $lesson_watched_achievement);
        $listener->handle($event);

        $lesson_watched_achievement->shouldNotHaveReceived('unlockForUser');
    }
}
