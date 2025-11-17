<?php

namespace Tests\Enums;

enum BlogEnum: int
{
    case LARAVEL_INSTALL = 1;
    case LARAVEL_NEW_PROJECT = 2;
    case LARAVEL_UNIT_TESTS = 3;
}
