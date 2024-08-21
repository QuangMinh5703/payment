<?php

namespace App\Models\Traits;

trait AutoTimestamps
{
    /**
     * Get the casts array.
     *
     * @return array
     */
    public function getCasts(): array
    {
        $casts = parent::getCasts();

        // Auto cast created_at, updated_at attribute
        if (array_key_exists('created_at', $this->attributes)) {
            $casts['created_at'] = 'datetime';
        }

        if (array_key_exists('updated_at', $this->attributes)) {
            $casts['updated_at'] = 'datetime';
        }

        return $casts;
    }

    /**
     * Determine if the model uses timestamps.
     *
     * @return bool
     */
    public function usesTimestamps(): bool
    {
        return false; // We use the database's timestamps, not this shit
    }
}
