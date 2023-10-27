<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Achievement
 *
 */
class Achievement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'action', 'action_count_required', 'level'];

    /**
     * Define the many-to-many relationship with users.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'achievement_user')->withTimestamps();
    }



    /**
     * Get the next achievement based on the 
     * achievement type (action) and the 
     * current level
     *
     * @return NULL|\App\Models\Achievement
     */
    public function getNextAchievement(): ?Achievement
    {
        $next_achievement = $this->where('action', $this->action)
            ->where('level', '>', $this->level)
            ->orderBy('level')
            ->first();

        if (($next_achievement)?->level == $this->level) {
            return NULL;
        }

        return $next_achievement;   
    }
}
