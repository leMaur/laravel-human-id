<?php

namespace Lemaur\HumanId\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use RuntimeException;

trait HasHuids
{
    /**
     * Initialize the trait.
     *
     * @return void
     */
    public function initializeHasHuids(): void
    {
        $this->usesUniqueIds = true;
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array
     */
    public function uniqueIds(): array
    {
        return [(string) config('human-id.field', 'huid')];
    }

    /**
     * Generate a new ULID for the model.
     *
     * @return string
     * @throws RuntimeException
     */
    public function newUniqueId(): string
    {
        if (! defined('static::HUID_PREFIX')) {
            throw new RuntimeException('Unable to find HUID_PREFIX. Please add it as private constant to your model.');
        }

        if (! is_string(static::HUID_PREFIX)) {
            throw new RuntimeException('HUID_PREFIX should contain only alpha characters.');
        }

        $len = strlen(static::HUID_PREFIX);

        if ($len < 1 || $len > 4) {
            throw new RuntimeException('HUID_PREFIX length should be between 1 and 4 characters.');
        }

        return Str::of(static::HUID_PREFIX)
            ->slug('')
            ->limit(4, '')
            ->append((string) config('human-id.separator', '_'))
            ->append(Str::ulid())
            ->lower()
            ->toString();
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  Model|Relation  $query
     * @param  mixed  $value
     * @param  string|null  $field
     * @return Relation
     *
     * @throws ModelNotFoundException
     */
    public function resolveRouteBindingQuery($query, $value, $field = null): Relation
    {
        if ($field && ! Str::isHuid($value) && in_array($field, $this->uniqueIds(), true)) {
            throw (new ModelNotFoundException)->setModel(get_class($this), $value);
        }

        if (! $field && ! Str::isHuid($value) && in_array($this->getRouteKeyName(), $this->uniqueIds(), true)) {
            throw (new ModelNotFoundException)->setModel(get_class($this), $value);
        }

        return parent::resolveRouteBindingQuery($query, $value, $field);
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        if (in_array($this->getKeyName(), $this->uniqueIds(), true)) {
            return 'string';
        }

        return $this->keyType;
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        if (in_array($this->getKeyName(), $this->uniqueIds(), true)) {
            return false;
        }

        return $this->incrementing;
    }
}
