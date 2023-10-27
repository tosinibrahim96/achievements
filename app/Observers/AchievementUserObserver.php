<?php

namespace App\Observers;

use App\Events\AchievementUnlocked;
use App\Models\AchievementUser;

class AchievementUserObserver
{
    /**
     * Handle the AchievementUser "created" event.
     */
    public function created(AchievementUser $user_achievement): void
    {
        event(new AchievementUnlocked($user_achievement->achievement->name, $user_achievement->user));
    }

    /**
     * Handle the AchievementUser "updated" event.
     */
    public function updated(AchievementUser $achievementUser): void
    {
        //
    }

    /**
     * Handle the AchievementUser "deleted" event.
     */
    public function deleted(AchievementUser $achievementUser): void
    {
        //
    }

    /**
     * Handle the AchievementUser "restored" event.
     */
    public function restored(AchievementUser $achievementUser): void
    {
        //
    }

    /**
     * Handle the AchievementUser "force deleted" event.
     */
    public function forceDeleted(AchievementUser $achievementUser): void
    {
        //
    }
}
