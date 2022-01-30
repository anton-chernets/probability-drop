<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
         \App\Models\Weight::factory(1)->create();
         \App\Models\Weight::factory(1)->create();
         \App\Models\Group::factory(5)->create();
         \App\Models\Player::factory(69)->create();
    }
}
