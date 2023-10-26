<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;


class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Badge::factory()->beginner()->create();
        Badge::factory()->intermediate()->create();
        Badge::factory()->advanced()->create();
        Badge::factory()->master()->create();
    }
}
