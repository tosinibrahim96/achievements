<?php

namespace App\Contracts\User;

interface CanUnlockAchievement
{
    /**
     * Unlock a new achievement for the user
     *
     * @param int $user_id
     * @param int $achievement_id
     * @return void
     */
    public function unlockAchievement(int $user_id, int $achievement_id): void;

}
