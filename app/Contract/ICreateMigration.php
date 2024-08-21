<?php

namespace App\Contract;

use App\Database\Blueprint;

interface ICreateMigration extends IMigration
{
    /**
     * Table definition
     *
     * @param Blueprint $table
     *
     * @return void
    */
    public function definition(Blueprint $table): void;
}
