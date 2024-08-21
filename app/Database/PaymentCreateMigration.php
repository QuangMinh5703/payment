<?php

namespace App\Database;

use App\Contract\ICreateMigration;

abstract class PaymentCreateMigration extends PaymentMigration implements ICreateMigration
{
    /**
     * {@inheritDoc}
     */
    abstract public function definition(Blueprint $table): void;

    /**
     * {@inheritDoc}
     */
    final public function _up(): void
    {
        $this->schema()->create($this->tableName(), fn (Blueprint $table) => $this->definition($table));
    }

    /**
     * {@inheritDoc}
     */
    final public function _down(): void
    {
        $this->schema()->dropIfExists($this->tableName());
    }
}
