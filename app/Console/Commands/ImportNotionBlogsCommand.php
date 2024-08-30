<?php

namespace App\Console\Commands;

use App\Actions\Notion\ImportAction;
use App\Enums\SiteEnum;
use App\Exceptions\SiteIdInvalidException;
use Illuminate\Console\Command;

class ImportNotionBlogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-notion {site}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports blogs from CMS';

    public function __construct(protected ImportAction $importAction)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $siteId = $this->argument('site');
        $site   = SiteEnum::tryFrom($siteId);

        throw_unless($site, SiteIdInvalidException::class, 'Site ID passed is invalid');

        $this->importAction->execute($site);

        $this->info('Import complete');
    }
}
