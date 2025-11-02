<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SiteSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Site::truncate();

        Site::insert([
            ['name' => 'DevPush'],
            ['name' => 'DevNudge'],
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
