<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAchievementResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    return [
        'unlocked_achievements' => $this->achievements->pluck('name')->toArray(),
        'next_available_achievements' => $this->getNextAvailableAchievements(),
        'current_badge' => $this->current_badge->name ?? '',
        'next_badge' => $this->next_badge->name ?? '',
        'remaing_to_unlock_next_badge' => $this->getAchievementsCountRemainingToUnlockNextBadge()
    ];
  }

  
  /**
   * Get next available achievements
   *
   * @return array
   */
  private function getNextAvailableAchievements(): array
  {
    $next_comment_achievement = $this->next_comment_achievement_to_unlock->name ?? '';
    $next_lesson_watched_achievement = $this->next_lesson_watched_achievement_to_unlock->name ?? '';

    return [$next_comment_achievement, $next_lesson_watched_achievement];
  }


  /**
   * Get next available achievements
   *
   * @return int
   */
  private function getAchievementsCountRemainingToUnlockNextBadge(): int
  {
    $remaing_to_unlock_next_badge = 0;

    if (isset($this->next_badge)) {
        $remaing_to_unlock_next_badge = $this->next_badge->achievement_count_required - $this->achievements->count();
    }

    return $remaing_to_unlock_next_badge;
  }
}
