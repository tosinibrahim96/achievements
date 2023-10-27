<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Badge
 *
 */
class Badge extends Model
{

    use HasFactory;

    protected $fillable = ['name', 'achievement_count_required', 'level'];

    /**
     * Define the many-to-many relationship with users.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'badge_user')->withTimestamps();
    }

    /**
     * Get the next badge based on the 
     * current level
     *
     * @return NULL|\App\Models\Badge
     */
    public function getNextBadge(): ?Badge
    {
        $next_badge = $this->where('level', '>', $this->level)
            ->orderBy('level')
            ->first();

        if (($next_badge)?->level == $this->level) {
            return NULL;
        }

        return $next_badge;   
    }
}
