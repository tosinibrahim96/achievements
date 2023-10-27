<?php

namespace App\Contracts\Achievement;

use App\Models\User;

interface CanBeUnlocked
{
    /**
     * Unlock a particular achievement/badge for 
     * the current user
     *
     * @param User $user
     * @return void
     */
    public function unlockForUser(User $user): void;
}
