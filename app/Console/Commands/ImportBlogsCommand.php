<?php

namespace App\Console\Commands;

use App\Actions\Blog\ImportAction;
use Illuminate\Console\Command;

class ImportBlogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-blogs';

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
        $this->importAction->execute();
        $this->info('Import complete');
    }
}
