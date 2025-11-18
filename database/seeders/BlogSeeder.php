<?php

namespace Database\Seeders;

use App\Actions\Blog\ResetAction;
use App\Enums\{BlogStatusEnum, SiteEnum};
use App\Models\{Blog, Tag};
use Illuminate\Database\Seeder;
use Tests\Enums\BlogEnum;
use Tests\Enums\TagEnum;
use Ramsey\Uuid\Uuid;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        resolve(ResetAction::class)->execute();

        $this->addBlogs();
        $this->addTags();
        $this->addBlogTags();
    }

    protected function addBlogs(): void
    {
        Blog::insert([
            [
                'id' => BlogEnum::LARAVEL_INSTALL,
                'site_id' => SiteEnum::DEVNUDGE,
                'notion_id' => Uuid::uuid4(),
                'title' => 'How to install Laravel',
                'slug' => 'how-to-install-laravel',
                'content' => $this->getContent(BlogEnum::LARAVEL_INSTALL),
                'status' => BlogStatusEnum::DONE,
                'published_at' => now()->subMonths(3),
            ],
            [
                'id' => BlogEnum::LARAVEL_NEW_PROJECT,
                'site_id' => SiteEnum::DEVNUDGE,
                'notion_id' => Uuid::uuid4(),
                'title' => 'How to create a new Laravel project',
                'slug' => 'laravel-new-project',
                'content' => $this->getContent(BlogEnum::LARAVEL_NEW_PROJECT),
                'status' => BlogStatusEnum::DONE,
                'published_at' => now()->subMonths(2),
            ],
            [
                'id' => BlogEnum::LARAVEL_UNIT_TESTS,
                'site_id' => SiteEnum::DEVNUDGE,
                'notion_id' => Uuid::uuid4(),
                'title' => 'How to run PHP unit tests in Laravel',
                'slug' => 'laravel-unit-tests',
                'content' => $this->getContent(BlogEnum::LARAVEL_UNIT_TESTS),
                'status' => BlogStatusEnum::DONE,
                'published_at' => now()->subMonths(1),
            ],
        ]);
    }

    protected function addTags(): void
    {
        Tag::insert([
            [
                'id' => TagEnum::LARAVEL,
                'site_id' => SiteEnum::DEVNUDGE,
                'notion_tag_id' => Uuid::uuid4(),
                'name' => 'Laravel',
                'color' => 'red',
            ],
        ]);
    }

    protected function addBlogTags(): void
    {
        Blog::find(BlogEnum::LARAVEL_INSTALL)->tags()->sync([TagEnum::LARAVEL]);
        Blog::find(BlogEnum::LARAVEL_NEW_PROJECT)->tags()->sync([TagEnum::LARAVEL]);
        Blog::find(BlogEnum::LARAVEL_UNIT_TESTS)->tags()->sync([TagEnum::LARAVEL]);
    }

    protected function getContent(BlogEnum $blog): string
    {
        return match ($blog) {
            BlogEnum::LARAVEL_INSTALL
                => "<h2>How to Install</h2><p>Go to the Laravel website and then go to the Installation page in the documentation section.</p><p>Scroll down to the Installing the Installer section and choose the command for your operating system.</p><h3>Windows</h3><code class='language-bash'># Run as administrator...
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))</code><h3>Mac OS</h3><code class='language-bash'>/bin/bash -c \"$(curl -fsSL https://php.new/install/mac/8.4)\"</code><h3>Linux</h3><code class='language-bash'>/bin/bash -c \"$(curl -fsSL https://php.new/install/linux/8.4)\"</code>",
            BlogEnum::LARAVEL_NEW_PROJECT
                => "<h2>How to create a new project</h2><p>Go to the Laravel website and then go to the Installation page in the documentation section.</p><p>Open up the terminal application that you would use for your operating system, gp to your directory you want to create the project and then run the following command to create the Laravel project.</p><code class='language-bash'>laravel new example-app</code>",
            BlogEnum::LARAVEL_UNIT_TESTS
                => "<h2>How to Run</h2><p>This command you can use to run unit tests in a Laravel project.</p><code class='language-php'>php artisan make:class
php artisan test</code>",
        };
    }
}
