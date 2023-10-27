<?php

namespace App\Services\User;

use App\Contracts\Achievement\IsAchievableViaNewMilestone;
use App\Contracts\User\CanReachNewMilestone;
use App\Models\User;

class UserService implements CanReachNewMilestone
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
  public function userHasReachedNewMilestone(User $user, IsAchievableViaNewMilestone $isAchievableViaNewMilestone): bool
  {
    return $isAchievableViaNewMilestone->hasReachedNewMilestone($user);
  }
}
