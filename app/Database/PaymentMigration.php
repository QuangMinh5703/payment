<?php

namespace App\Database;

use App\Contract\IMigration;
use Illuminate\Database\Connection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\DB;

abstract class PaymentMigration extends Migration implements IMigration
{
    /**
     * Get table name to run migration
    */
    abstract public function tableName(): string;

    /**
     * Run the migrations.
    */
    final public function up(): void
    {
        $this->_up();
    }

    /**
     * Reverse the migrations.
     */
    final public function down(): void
    {
        $this->_down();
    }

    /**
     * Get schema builder
     */
    protected function schema(): Builder
    {
        $schema = $this->db()->getSchemaBuilder();

        $schema->blueprintResolver(fn ($table, $callback) => new Blueprint($table, $callback));

        return $schema;
    }

    protected function db(): Connection
    {
        return DB::connection($this->getConnection());
    }
}
