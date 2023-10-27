<?php

namespace App\Observers;

use App\Events\BadgeUnlocked;
use App\Models\BadgeUser;

class BadgeUserObserver
{
    /**
     * Handle the BadgeUser "created" event.
     *
     * @param  BadgeUser  $badgeUser
     * @return void
     */
    public function created(BadgeUser $badge_user)
    {
        event(new BadgeUnlocked($badge_user->badge->name, $badge_user->user));
    }

    /**
     * Handle the BadgeUser "updated" event.
     */
    public function updated(BadgeUser $badgeUser): void
    {
        //
    }

    /**
     * Handle the BadgeUser "deleted" event.
     */
    public function deleted(BadgeUser $badgeUser): void
    {
        //
    }

    /**
     * Handle the BadgeUser "restored" event.
     */
    public function restored(BadgeUser $badgeUser): void
    {
        //
    }

    /**
     * Handle the BadgeUser "force deleted" event.
     */
    public function forceDeleted(BadgeUser $badgeUser): void
    {
        //
    }
}
