<?php

namespace App\Enums\Status;

enum BlogStatusEnum: string
{
    case DRAFT       = 'draft';
    case PUBLISHED   = 'published';
    case UNPUBLISHED = 'unpublished';
}
