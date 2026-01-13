<?php

namespace App\Console\Commands;

use App\Actions\Blog\ResetAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class DeleteAllBlogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-all-blogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all blogs in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!App::environment('production')) {
            resolve(ResetAction::class)->execute();
        }
    }
}
