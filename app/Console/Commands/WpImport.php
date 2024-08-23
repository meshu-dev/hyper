<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Actions\WpImport\{WpCategoryImportAction, WpPostImportAction};
use App\Actions\Vercel\CallDeployWebhookAction;

class WpImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-wp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import wp data to RequireDev API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (app()->make(WpCategoryImportAction::class))->execute();
        (app()->make(WpPostImportAction::class))->execute();
        //(app()->make(CallDeployWebhookAction::class)->execute());
    }
}
