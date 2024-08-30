<?php

namespace App\Enums\Status;

enum NotionStatusEnum: string
{
    case NOT_STARTED = 'Not started';
    case IN_PROGRESS = 'In progress';
    case DONE        = 'Done';
}
