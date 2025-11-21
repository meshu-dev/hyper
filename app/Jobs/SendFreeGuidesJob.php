<?php

namespace App\Jobs;

use App\Actions\Newsletter\SendFreeGuidesAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFreeGuidesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected SendFreeGuidesAction $sendFreeGuidesAction;

    /**
     * Create a new job instance.
     *
     * @param array<string, mixed> $params
     */
    public function __construct(
        public int $subscriberId
    ) {
        $this->sendFreeGuidesAction = resolve(SendFreeGuidesAction::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->sendFreeGuidesAction->execute($this->subscriberId);
    }
}
