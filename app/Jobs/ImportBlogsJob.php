<?php

namespace App\Jobs;

use App\Actions\Newsletter\SendFreeGuidesAction;
use App\Actions\Notion\Import\NotionImportDatabaseAction;
use App\Actions\Vercel\DeployWebhookAction;
use App\Enums\SiteEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportBlogsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param SiteEnum $site
     */
    public function __construct(
        public SiteEnum $site
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $databaseId = config("services.notion.{$this->site->key}.database_id");

        resolve(NotionImportDatabaseAction::class)->execute($databaseId, $this->site);

        resolve(DeployWebhookAction::class)->execute($this->site);
    }
}
