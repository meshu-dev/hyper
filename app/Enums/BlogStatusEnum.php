<?php

namespace App\Enums;

enum BlogStatusEnum: string
{
    case NOT_STARTED = 'Not started';
    case IN_PROGRESS = 'In progress';
    case DONE        = 'Done';
}
