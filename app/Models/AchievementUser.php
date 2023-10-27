<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class AchievementUser
 */
class AchievementUser extends Pivot
{
    use HasFactory;

    protected $table = 'achievement_user';


    /**
     * Define the belongs-to relationship with users.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Define the belongs-to relationship with achievements.
     *
     * @return BelongsTo
     */
    public function achievement(): BelongsTo
    {
        return $this->belongsTo(Achievement::class);
    }
}
