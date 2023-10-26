<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\AchievementUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class AchievementUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Achievement::count() === 0) {
            $this->call(AchievementSeeder::class);
        }
        
        AchievementUser::factory(10)->create();
    }
}
