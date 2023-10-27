<?php

namespace App\Services\Achievement;

use App\Contracts\Achievement\CanBeUnlocked;
use App\Contracts\Achievement\IsAchievableViaNewMilestone;
use App\Models\Achievement;
use App\Models\User;
use App\Services\User\UserAchievementService;

class CommentWrittenAchievement implements IsAchievableViaNewMilestone, CanBeUnlocked
{

  protected $user_achievement_service;

  /**
   * __construct
   *
   * @return void
   */
  public function __construct(UserAchievementService $user_achievement_service)
  {
    $this->user_achievement_service = $user_achievement_service;
  }

  
  /**
   *
   * @inheritdoc
   */
  public function hasReachedNewMilestone(User $user): bool
  {
    $comments_count = $user->comments->count();

    $achievement = Achievement::where('action', COMMENT_WRITTEN)
        ->where('action_count_required', $comments_count)
        ->first();
    
    if (!isset($achievement)) {
        return false;
    }

    if ($this->user_achievement_service->userAlreadyHasAchievement($user, $achievement->id)) {
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

    $comments_count = $user->comments->count();

    $nextAchievement = Achievement::where('action', COMMENT_WRITTEN)
        ->where('action_count_required', '>=', $comments_count)
        ->orderBy('action_count_required')
        ->first();
    
    if (!isset($nextAchievement)) {
      return;
    }
  
    $this->user_achievement_service->unlockAchievement($user->id, $nextAchievement->id);
  }
}
