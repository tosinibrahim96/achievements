<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Services\Badge\AchievementBadge;
use App\Services\User\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class AchievementUnlockedListener implements ShouldQueue
{
    use InteractsWithQueue;

    protected $user_service, $achievement_badge;

    /**
     * Create the event listener.
     * 
     * @param \App\Services\User\UserService $user_service
     * @param \App\Services\Badge\AchievementBadge $achievement_badge
     * @return void
     */
    public function __construct(UserService $user_service, AchievementBadge $achievement_badge)
    {
        $this->user_service = $user_service;
        $this->achievement_badge = $achievement_badge;
    }

    /**
     * Handle the event.
     * 
     * @param \App\Events\AchievementUnlocked $event
     * @return void
     */
    public function handle(AchievementUnlocked $event): void
    {
        $user = $event->user;
        
        $userHasReachedNewMilestone = $this->user_service
            ->userHasReachedNewMilestone($user, $this->achievement_badge);

        if($userHasReachedNewMilestone){
            $this->achievement_badge->unlockForUser($user);
        }
    }
}