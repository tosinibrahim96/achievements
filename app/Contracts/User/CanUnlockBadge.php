<?php

namespace App\Contracts\User;

interface CanUnlockBadge
{
    /**
     * Unlock a new badge for the user
     *
     * @param int $user_id
     * @param int $badge_id
     * @return void
     */
    public function unlockBadge(int $user_id, int $badge_id): void;

}
