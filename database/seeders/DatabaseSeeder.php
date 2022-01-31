<?php

namespace Database\Seeders;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Schedule $schedule)
    {
        // \App\Models\User::factory(10)->create();
         \App\Models\Group::factory(5)->create();
        Artisan::call('weights:reset');
         \App\Models\Player::factory(69)->create();
    }
}
