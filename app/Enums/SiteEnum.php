<?php

namespace App\Enums;

enum SiteEnum: int
{
    case DEVPUSH  = 1;
    case DEVNUDGE = 2;

    public static function fromKey(string $key): self
    {
        return match($key) {
            'devpush'  => SiteEnum::DEVPUSH,
            'devnudge' => SiteEnum::DEVNUDGE,
        };
    }
}
