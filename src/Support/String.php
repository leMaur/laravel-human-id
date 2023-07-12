<?php

namespace Lemaur\HumanId\Support;

use Illuminate\Support\Str;
use Symfony\Component\Uid\Ulid;

/**
 * Determine if a given string is a valid HUID.
 *
 * @param  string  $value
 * @return bool
 */
Str::macro('isHuid', static function ($value) {
    if (! is_string($value)) {
        return false;
    }

    $separator = (string) config('human-id.separator', '_');

    if (! str_contains($value, $separator)) {
        return false;
    }

    return Ulid::isValid(last(explode($separator, $value, 2)))
        && preg_match('/^[a-z]{1,4}'.$separator.'[0-9a-z]{26}$/', $value);
});
