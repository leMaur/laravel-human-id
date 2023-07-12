<?php

use Illuminate\Support\Str;
use Symfony\Component\Uid\Ulid;

it('checks if a string is a human id', function (): void {
    expect(Str::isHuid('invalid human_id'))->toBeFalse();
    expect(Str::isHuid(123))->toBeFalse();
    expect(Str::isHuid(null))->toBeFalse();
    expect(Str::isHuid([]))->toBeFalse();

    $testHuid = Str::lower('post_'.Ulid::fromString('01GNNA1J00DYW71SWPDHN0F1S5'));

    expect(Str::isHuid($testHuid))->toBeTrue();
});
