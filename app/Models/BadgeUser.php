<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class BadgeUser
 */
class BadgeUser extends Pivot
{
    use HasFactory;

    protected $table = 'badge_user';
}
