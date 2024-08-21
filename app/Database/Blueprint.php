<?php
/*
 * Copyright (c) 2022-2024. Kinal Games, Inc. All Rights Reserved.
 */

declare(strict_types=1);

namespace App\Database;

use Illuminate\Database\Schema\Blueprint as BaseBlueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;

class Blueprint extends BaseBlueprint
{
    public function autoTimestamps(): void
    {
        $this->timestamp('created_at')->useCurrent();
        $this->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
    }

    public function integerForeignId(string $column): ForeignIdColumnDefinition|ColumnDefinition
    {
        return $this->addColumnDefinition(new ForeignIdColumnDefinition($this, [
            'type' => 'integer',
            'name' => $column,
            'autoIncrement' => false,
            'unsigned' => true,
        ]));
    }

    public function stringForeignId(string $column, ?int $length = null): ForeignIdColumnDefinition|ColumnDefinition
    {
        $length = $length ?: Builder::$defaultStringLength;

        return $this->addColumnDefinition(new ForeignIdColumnDefinition($this, [
            'type' => 'string',
            'name' => $column,
            'length' => $length,
        ]));
    }

    /**
     * Add the proper columns for a polymorphic table using numeric IDs (incremental).
     */
    public function stringMorphs(string $name, int $keyLength = 32, ?string $indexName = null): void
    {
        $this->string("{$name}_type");

        $this->string("{$name}_id", $keyLength);

        $this->index(["{$name}_type", "{$name}_id"], $indexName);
    }

    /**
     * Create a new decimal column on the table.
     */
    public function unsignedDecimal(string $column, int $total = 8, int $places = 2): ColumnDefinition
    {
        return $this->decimal($column, $total, $places)->unsigned();
    }
}
