<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\BadgeUser;
use Illuminate\Database\Seeder;

class BadgeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Badge::count() === 0) {
            $this->call(BadgeSeeder::class);
        }
        
        BadgeUser::factory(10)->create();
    }
}
