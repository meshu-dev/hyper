<?php

namespace App\Enums;

enum StatusEnum: string
{
    case NOT_STARTED = 'Not started';
    case IN_PROGRESS = 'In progress';
    case DONE        = 'Done';
}
