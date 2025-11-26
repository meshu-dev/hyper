<?php

namespace Database\Factories;

use App\Enums\BlogStatusEnum;
use App\Enums\SiteEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class BlogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'site_id' => SiteEnum::DEVNUDGE->value,
            'notion_id' => fake()->uuid(),
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'content' => fake()->randomHtml(),
            'status' => BlogStatusEnum::DONE->value,
            'published_at' => now(),
        ];
    }
}
