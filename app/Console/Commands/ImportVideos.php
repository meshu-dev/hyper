<?php

namespace App\Console\Commands;

use App\Actions\YouTube\ImportVideosAction;
use Illuminate\Console\Command;

class ImportVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports and stores the DevPush YouTube videos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        resolve(ImportVideosAction::class)->execute();
    }
}
