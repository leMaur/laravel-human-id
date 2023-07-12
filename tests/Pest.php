<?php

use Illuminate\Support\Str;
use Lemaur\HumanId\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

expect()->extend('toBeHuid', function () {
    return expect(Str::isHuid($this->value))->toBeTrue();
});
