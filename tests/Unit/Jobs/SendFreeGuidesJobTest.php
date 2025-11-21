<?php

use App\Actions\Newsletter\SendFreeGuidesAction;
use App\Jobs\SendFreeGuidesJob;
use Mockery\MockInterface;

describe('Jobs - SendFreeGuidesJob', function () {
    it('runs the job', function () {
        // Arrange
        $subscriberId = 1;

        // Assert
        $job = mock(SendFreeGuidesAction::class, function (MockInterface $mock) use ($subscriberId) {
            $mock->shouldReceive('execute')
                ->once()
                ->with($subscriberId);
        });

        $this->app->bind(SendFreeGuidesAction::class, fn () => $job);

        // Act
        resolve(SendFreeGuidesJob::class, ['subscriberId' => $subscriberId])->handle();
    });
});
