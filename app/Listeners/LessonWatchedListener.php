<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Services\Achievement\LessonWatchedAchievement;
use App\Services\User\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LessonWatchedListener implements ShouldQueue
{
    use InteractsWithQueue;

    protected $user_service, $lesson_watched_achievement;

    /**
     * Create the event listener.
     * 
     * @param \App\Services\User\UserService $user_service
     * @param \App\Services\Achievement\LessonWatchedAchievement $lesson_watched_achievement
     * @return void
     */
    public function __construct(UserService $user_service, LessonWatchedAchievement $lesson_watched_achievement)
    {
        $this->user_service = $user_service;
        $this->lesson_watched_achievement = $lesson_watched_achievement;
    }

    /**
     * Handle the event.
     * 
     * @param \App\Events\LessonWatched $event
     * @return void
     */
    public function handle(LessonWatched $event): void
    {
        $user = $event->user;

        if (!isset($user)) {
            Log::error("Cannot find user for lesson watched event", [$event->lesson]);
            return;
        }

        $userHasReachedNewMilestone = $this->user_service
            ->userHasReachedNewMilestone($user, $this->lesson_watched_achievement);

        if($userHasReachedNewMilestone){
            $this->lesson_watched_achievement->unlockForUser($user);
        }
    }
}
