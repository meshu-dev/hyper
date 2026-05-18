<?php

use App\Enums\SiteEnum;
use App\Jobs\ImportBlogsJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
 
//Schedule::job(resolve(ImportBlogsJob::class, ['site' => SiteEnum::DEVNUDGE]))->dailyAt('12:00');
