<?php

use App\Enums\SiteEnum;

return [
    SiteEnum::DEV_NUDGE->value => [
        'items_per_page'     => env('BLOG_ITEMS_PER_PAGE', 10),
        'latest_total'       => env('BLOG_LATEST_TOTAL', 3),
        'notion_database_id' => env('NOTION_DEVNUDGE_DATABASE_ID'),
        'deploy_hook_url'    => env('VERCEL_DEVNUDGE_DEPLOY_HOOK'),
    ],
    SiteEnum::DEV_PUSH->value  => [
        'items_per_page'     => env('BLOG_ITEMS_PER_PAGE', 10),
        'latest_total'       => env('BLOG_LATEST_TOTAL', 3),
        'notion_database_id' => env('NOTION_DEVPUSH_DATABASE_ID'),
        'deploy_hook_url'    => env('VERCEL_DEVPUSH_DEPLOY_HOOK'),
    ]
];
