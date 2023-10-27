<?php

namespace App\Services\User;

use App\Contracts\User\CanUnlockBadge;
use App\Events\BadgeUnlocked;
use App\Models\BadgeUser;
use App\Models\User;

class UserBadgeService implements CanUnlockBadge
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        
    }
    
    /**
     * @inheritdoc
     */
    public function unlockBadge(int $user_id, int $badge_id): void
    {
        $userBadge = BadgeUser::updateOrCreate([
            'badge_id' => $badge_id,
            'user_id' => $user_id
        ]);
    }


    /**
     * Check if the user already has a 
     * particular badge
     *
     * @param User $user
     * @param int $badge_id
     * @return bool
     */
    public function userAlreadyHasBadge(User $user, int $badge_id)
    {
        return $user->badges()
            ->wherePivot('badge_id', $badge_id)
            ->count() > 0;
    }
}
