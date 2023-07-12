<?php

namespace Lemaur\HumanId\Database\Schema\Blueprints;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

/**
 * Create a new HUID column on the table.
 *
 * @param  string|null  $column
 * @return ColumnDefinition
 */
Blueprint::macro('huid', function (string $column = null) {
    if ($column === null) {
        $column = (string) config('human-id.field', 'huid');
    }

    return $this->char($column, 31);
});
