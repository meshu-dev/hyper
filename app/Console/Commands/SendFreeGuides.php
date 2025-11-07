<?php

namespace App\Console\Commands;

use App\Actions\Newsletter\SendFreeGuidesAction;
use Illuminate\Console\Command;

class SendFreeGuides extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-free-guides';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send FREE guides to users subscribed to newsletter';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $result = resolve(SendFreeGuidesAction::class)->execute();

        $this->info('Free guides sent | Sent: '.$result);
    }
}
