<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class AchievementUser
 */
class AchievementUser extends Pivot
{
    use HasFactory;

    protected $table = 'achievement_user';
}
