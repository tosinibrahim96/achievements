<?php

namespace App\Services\User;

use App\Contracts\User\CanUnlockAchievement;
use App\Events\AchievementUnlocked;
use App\Models\AchievementUser;
use App\Models\User;

class UserAchievementService implements CanUnlockAchievement
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
     *
     * @inheritdoc
     */
    public function unlockAchievement(int $user_id, int $achievement_id): void
    {
        $user_achievement = AchievementUser::updateOrCreate([
            'achievement_id' => $achievement_id,
            'user_id' => $user_id
        ]);
    }


    /**
     * Check if the user already has a 
     * particular achievement
     *
     * @param User $user
     * @param int $achievement_id
     * @return bool
     */
    public function userAlreadyHasAchievement(User $user, int $achievement_id): bool
    {
        return $user->achievements()
            ->wherePivot('achievement_id', $achievement_id)
            ->count() > 0;
    }
}
