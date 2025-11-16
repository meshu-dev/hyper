<?php

namespace App\Console\Commands;

use App\Actions\Blog\ResetAction;
use App\Actions\Notion\NotionImportPagesAction;
use App\Enums\SiteEnum;
use Illuminate\Console\Command;

class ImportBlogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-blogs {reset=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports and stores the DevNudge Notion blogs';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $doReset = $this->argument('reset') === 'true' ? true : false;

        if ($doReset) {
            resolve(ResetAction::class)->execute();
        }

        $databaseId = config('services.notion.devnudge.database_id');
        $siteId = SiteEnum::DEVNUDGE->value;

        resolve(NotionImportPagesAction::class)->execute($databaseId, $siteId);
    }
}
