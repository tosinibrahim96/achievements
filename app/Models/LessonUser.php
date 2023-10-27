<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class LessonUser
 */
class LessonUser extends Pivot
{
    use HasFactory;

    protected $table = 'lesson_user';
}
