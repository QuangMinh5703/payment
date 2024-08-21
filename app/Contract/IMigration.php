<?php

namespace App\Contract;

interface IMigration
{
    /**
     * Get table name to run migration.
     *
     * @return string
     */
    public function tableName(): string;

    /**
     * Private function to up migration scenario
     *
     * @return void
     */
    public function _up(): void;

    /**
     * Private function to down migration scenario
     *
     * @return void
     */
    public function _down(): void;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void;

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void;
}
