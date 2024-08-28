<?php

namespace Database\Seeders;

use App\Enums\SiteEnum;
use App\Models\Site;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Site::create([
            'id'   => SiteEnum::DEV_NUDGE->value,
            'name' => 'devnudge'
        ]);

        Site::create([
            'id'   => SiteEnum::DEV_PUSH->value,
            'name' => 'devpush'
        ]);
    }
}
