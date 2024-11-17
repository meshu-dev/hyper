<?php

namespace App\Actions\Site\DevPush;

use App\Enums\SiteEnum;
use App\Services\Notion\NotionImportService;
use App\Services\Wordpress\WpImportService;
use App\Services\VercelService;

class DeploySiteAction
{
    public function __construct(
        protected WpImportService $wpImportService,
        protected NotionImportService $notionImportService,
        protected VercelService $vercelService
    ) {
    }

    public function execute()
    {
        $site       = SiteEnum::DEV_PUSH;
        $databaseId = config('sites.' . $site->value . '.notion_database_id');

        // Import Wordpress blogs
        $this->wpImportService->import();

        // Import Notion blogs
        $this->notionImportService->import($site, $databaseId);

        // Call deploy hook to re-build DevPush frontend site
        $deployHookUrl = config('sites.' . $site->value . '.deploy_hook_url');
        $this->vercelService->callDeployHook($deployHookUrl);
    }
}
