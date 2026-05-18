<?php

namespace App\Enums;

use UnhandledMatchError;

enum SiteEnum: int
{
    case DEVPUSH = 1;
    case DEVNUDGE = 2;

    public function key()
    {
        return match ($this->value) {
            self::DEVPUSH->value  => 'devpush',
            self::DEVNUDGE->value => 'devnudge',
        }; 
    }

    public static function fromKey(string $key): self
    {
        return match ($key) {
            'devpush' => SiteEnum::DEVPUSH,
            'devnudge' => SiteEnum::DEVNUDGE,
            default => throw new UnhandledMatchError(),
        };
    }
}
