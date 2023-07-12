<?php

use Illuminate\Database\Eloquent\Model;
use Lemaur\HumanId\Concerns\HasHuids;

it('automatically generates human id', function () {
    expect(TestModelWithPrefix::create()->huid)
        ->toBeHuid()
        ->toStartWith('usr_');
});

it('fails if prefix is not set', function () {
    TestModelWithoutPrefix::create();
})->throws(RuntimeException::class);

class TestModelWithPrefix extends Model
{
    use HasHuids;

    private const HUID_PREFIX = 'usr';

    protected $table = 'my_table';
}

class TestModelWithoutPrefix extends Model
{
    use HasHuids;

    protected $table = 'my_table';
}
