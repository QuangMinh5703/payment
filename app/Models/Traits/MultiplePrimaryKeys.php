<?php
/*
 * Copyright (c) 2022-2024. Kinal Games, Inc. All Rights Reserved.
 */

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Support multiple primary keys for Model
 */
trait MultiplePrimaryKeys
{
    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        $keys = $this->getKeyName();
        if (is_array($keys)) {
            return false; // disable auto-increment when the Model has multiple primary keys
        }

        return $this->incrementing;
    }

    /**
     * Set the keys for a save update query.
     *
     * @param  Builder  $query
     */
    protected function setKeysForSaveQuery($query): Builder
    {
        $keys = $this->getKeyName();
        if (! is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     */
    protected function getKeyForSaveQuery(mixed $keyName = null): mixed
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
