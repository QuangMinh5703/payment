<?php

namespace App;

use App\Contract\IPayment;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;

class Payment implements IPayment
{

    public function dbConnectionName(): string
    {
        return 'kinalgames';
    }

    public function dbConnection(): ConnectionInterface
    {
        return DB::connection($this->dbConnectionName());
    }
}
