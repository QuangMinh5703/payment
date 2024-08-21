<?php

namespace App\Contract;

use Illuminate\Database\ConnectionInterface;

interface IPayment
{
    /**
     * Payment database connection name
     *
     * @return string
     */
    public function dbConnectionName(): string;

    /**
     * Payment database connection
     *
     * @return ConnectionInterface
     */
    public function dbConnection(): ConnectionInterface;
}
