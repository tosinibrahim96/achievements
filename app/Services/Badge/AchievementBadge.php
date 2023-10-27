<?php

namespace App\Services\Badge;

use App\Contracts\Achievement\CanBeUnlocked;
use App\Contracts\Achievement\IsAchievableViaNewMilestone;
use App\Models\Badge;
use App\Models\User;
use App\Services\User\UserBadgeService;

class AchievementBadge implements IsAchievableViaNewMilestone, CanBeUnlocked
{
    protected $user_badge_service;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(UserBadgeService $user_badge_service)
    {
      $this->user_badge_service = $user_badge_service;
    }

  
  /**
   * @inheritdoc
   */
  public function hasReachedNewMilestone(User $user): bool
  {
    $achievements_count = $user->achievements->count();

    $badge = Badge::where('achievement_count_required', $achievements_count)
        ->first();

    if (!isset($badge)) {
        return false;
    }

    if ($this->user_badge_service->userAlreadyHasBadge($user, $badge->id)) {
        return false;
    }

    return true;
  }
  
  /**
   * @inheritdoc
   */
  public function unlockForUser(User $user): void
  {
    /**
     * If for any reason, the 'hasReachedNewMilestone' method was not 
     * called before this, then let's handle that here
     */
    if (!$this->hasReachedNewMilestone($user)) {
      return;
    }

    $achievements_count = $user->achievements->count();

    $nextBadge = Badge::where('achievement_count_required', '>=', $achievements_count)
        ->orderBy('achievement_count_required')
        ->first();

    if (!$nextBadge) {
      return;
    }

    $this->user_badge_service->unlockBadge($user->id, $nextBadge->id);
  }
}
