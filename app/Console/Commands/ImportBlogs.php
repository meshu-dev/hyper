<?php

namespace App\Console\Commands;

use App\Actions\Notion\Import\NotionImportDatabaseAction;
use App\Enums\SiteEnum;
use Illuminate\Console\Command;

class ImportBlogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-blogs {site}';

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
        $siteKey = $this->argument('site');

        $databaseId = config("services.notion.$siteKey.database_id");
        $site       = SiteEnum::fromKey($siteKey);

        resolve(NotionImportDatabaseAction::class)->execute($databaseId, $site);
    }
}
