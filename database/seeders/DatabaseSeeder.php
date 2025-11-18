<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $seeders = [
            UserSeeder::class,
            SiteSeeder::class,
            FreeGuideSeeder::class,
            SubscriberSeeder::class,
            BlogSeeder::class,
        ];

        if (App::environment('local')) {
            $seeders[] = SubscriberSeeder::class;
        }

        $this->call($seeders);
    }
}
