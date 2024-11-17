<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Enums\SiteEnum;
use App\Exceptions\SiteIdInvalidException;
use App\Factories\DeploySiteActionFactory;

class DeploySiteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deploy-site {site}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import latest blog updates and deploy site';

    public function __construct(protected DeploySiteActionFactory $deploySiteActionFactory)
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

        $action = $this->deploySiteActionFactory->make($site);
        $action->execute();

        $this->info('Deployed site');
    }
}
