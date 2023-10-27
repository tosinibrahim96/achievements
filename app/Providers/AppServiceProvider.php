<?php

namespace App\Providers;

use App\Models\AchievementUser;
use Illuminate\Support\ServiceProvider;
use App\Models\BadgeUser;
use App\Observers\AchievementUserObserver;
use App\Observers\BadgeUserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        BadgeUser::observe(BadgeUserObserver::class);
        AchievementUser::observe(AchievementUserObserver::class);
    }
}
