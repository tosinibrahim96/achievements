<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::factory()->create();

         User::factory()->unverified()->create();
 
         User::factory(5)->create([
             'name' => 'John Doe',
             'email' => 'johndoe@example.com',
         ]);
    }
}
