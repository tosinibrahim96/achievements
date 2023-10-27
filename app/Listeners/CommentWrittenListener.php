<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Services\Achievement\CommentWrittenAchievement;
use App\Services\User\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CommentWrittenListener implements ShouldQueue
{
    use InteractsWithQueue;

    protected $user_service, $comment_written_achievement;

    /**
     * Create the event listener.
     * 
     * @param \App\Services\User\UserService $user_service
     * @param \App\Services\Achievement\CommentWrittenAchievement $comment_written_achievement
     * @return void
     */
    public function __construct(UserService $user_service, CommentWrittenAchievement $comment_written_achievement)
    {
        $this->user_service = $user_service;
        $this->comment_written_achievement = $comment_written_achievement;
    }

     /**
     * Handle the event.
     * 
     * @param \App\Events\CommentWritten $event
     * @return void
     */
    public function handle(CommentWritten $event): void
    {
        $user = $event->comment->user;

        if (!isset($user)) {
            Log::error("Cannot find user for comment", [$event->comment]);
            return;
        }

        $userHasReachedNewMilestone = $this->user_service
            ->userHasReachedNewMilestone($user, $this->comment_written_achievement);

        if($userHasReachedNewMilestone){
            $this->comment_written_achievement->unlockForUser($user);
        }
    }
}