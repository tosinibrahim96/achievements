<?php

namespace App\Contracts\User;

use App\Contracts\Achievement\IsAchievableViaNewMilestone;
use App\Models\User;

interface CanReachNewMilestone
{
    /**
     * Check if a user has reached a 
     * new milestone based on an action taken
     *
     * @param User $user
     * @param \App\Contracts\Achievement\IsAchievableViaNewMilestone $is_achievable_via_new_milestone
     * @return bool
     */
    public function userHasReachedNewMilestone(User $user, IsAchievableViaNewMilestone $is_achievable_via_new_milestone): bool;
}
