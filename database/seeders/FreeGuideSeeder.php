<?php

namespace Database\Seeders;

use App\Models\FreeGuide;
use Illuminate\Database\Seeder;

class FreeGuideSeeder extends Seeder
{
    public function run(): void
    {
        FreeGuide::truncate();

        FreeGuide::insert([
            ['name' => 'HTML - Crash Course', 'filename' => 'html-crash-course.pdf'],
            ['name' => 'Web Developer Roadmap', 'filename' => 'roadmap.pdf'],
            ['name' => 'Web Developer Software Setup', 'filename' => 'software-setup.pdf'],
        ]);
    }
}
