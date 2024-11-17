<?php

namespace App\Actions\Site\DevNudge;

use App\Enums\SiteEnum;
use App\Services\Notion\NotionImportService;
use App\Services\VercelService;

class DeploySiteAction
{
    public function __construct(
        protected NotionImportService $notionImportService,
        protected VercelService $vercelService
    ) {
    }

    public function execute()
    {
        $site       = SiteEnum::DEV_NUDGE;
        $databaseId = config('sites.' . $site->value . '.notion_database_id');

        // Import Notion blogs
        $this->notionImportService->import($site, $databaseId);

        // Call deploy hook to re-build DevNudge frontend site
        $deployHookUrl = config('sites.' . $site->value . '.deploy_hook_url');
        $this->vercelService->callDeployHook($deployHookUrl);
    }
}
