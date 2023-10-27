<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }


     /**
     * Get the achievements that belongs to the user
     *
     * @return BelongsToMany
     */
    public function achievements(): BelongsToMany {
        return $this->belongsToMany(Achievement::class, 'achievement_user', 'user_id', 'achievement_id')->withTimestamps();
    }

    /**
     * Get the badges that belongs to the user
     *
     * @return BelongsToMany
     */
    public function badges(): BelongsToMany {
        return $this->belongsToMany(Badge::class, 'badge_user', 'user_id', 'badge_id')->withTimestamps();
    }


    /**
     * Get highest comment achievement that belongs to the user
     *
     * @return NULL|\App\Models\Achievement
     */
    public function getHighestCommentAchievementAttribute(): ?Achievement
    {
        return $this->achievements()->where('action', COMMENT_WRITTEN)
            ->orderByDesc('level')
            ->first();
    }

    /**
     * Get highest lesson watched achievement that belongs to the user
     *
     * @return NULL|\App\Models\Achievement
     */
    public function getHighestLessonWatchedAchievementAttribute(): ?Achievement
    {
        return $this->achievements()->where('action', LESSON_WATCHED)
            ->orderByDesc('level')
            ->first();
    }


    /**
     * Get the current badge that belongs to the user
     *
     * @return NULL|\App\Models\Badge
     */
    public function getCurrentBadgeAttribute(): ?Badge
    {
        return $this->badges()->orderByDesc('level')->first();
    }


     /**
     * Get the next achievement that can be unlocked 
     * by the user when they write comments
     *
     * @return NULL|\App\Models\Achievement
     */
    public function getNextCommentAchievementToUnlockAttribute(): ?Achievement
    {
        $highestCommentAchievement = $this->getHighestCommentAchievementAttribute();

        /**
         * If the user does not have any achievements based 
         * on comments, then the next achievement will
         * be the lowest achievemtnt that can be unlocked
         * via writing a comment
         */
        if (!isset($highestCommentAchievement)) {
            return Achievement::whereAction(COMMENT_WRITTEN)->whereLevel(1)->first();
        }
        
        return $highestCommentAchievement->getNextAchievement();
    }


    /**
     * Get the next achievement that can be unlocked 
     * by the user when they watch lessons
     *
     * @return NULL|\App\Models\Achievement
     */
    public function getNextLessonWatchedAchievementToUnlockAttribute(): ?Achievement
    {
        $highestLessonWatchedAchievement = $this->getHighestLessonWatchedAchievementAttribute();

        /**
         * If the user does not have any achievements based 
         * on lessons watched, then the next achievement will
         * be the lowest achievemtnt that can be unlocked
         * via watching a lesson
         */
        if (!isset($highestLessonWatchedAchievement)) {
            return Achievement::whereAction(LESSON_WATCHED)->whereLevel(1)->first();
        }

        return $highestLessonWatchedAchievement->getNextAchievement();
    }


    /**
     * Get the next badge that can be unlocked 
     * by the user
     *
     * @return NULL|\App\Models\Badge
     */
    public function getNextBadgeAttribute(): ?Badge
    {
        $currentBadge = $this->getCurrentBadgeAttribute();

        /**
         * If the user does not have any badge then the next badge will
         * be the lowest badge that can be unlocked
         */
        if (!isset($currentBadge)) {
            return Badge::whereLevel(1)->first();
        }

        return $currentBadge->getNextBadge();
    }
}

