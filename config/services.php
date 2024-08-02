<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'notion' => [
        'api' => [
            'url'         => env('NOTION_API_URL', 'https://api.notion.com/v1'),
            'token'       => env('NOTION_TOKEN'),
            'version'     => env('NOTION_VERSION', '2022-06-28'),
            'database_id' => env('NOTION_DATABASE_ID')
        ],
        'page_to_html' => [
            'url' => env('NOTION_PAGE_TO_HTML_URL', 'http://localhost:8787')
        ]
    ]
];
