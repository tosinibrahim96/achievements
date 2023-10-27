<?php

namespace App\Contracts\Achievement;

use App\Models\User;

interface IsAchievableViaNewMilestone
{
    /**
     * Check if the user has satisfied all the conditions 
     * for a new milestone
     *
     * @param User $user
     * @return bool
     */
    public function hasReachedNewMilestone(User $user): bool;
}
