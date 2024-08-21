<?php

declare(strict_types=1);

namespace App\Models;

use App\Facade\Payment;
use Illuminate\Support\Facades\DB;

abstract class PayModel extends KinalModel
{
    public function __construct(array $attributes = [])
    {
        $this->table = DB::connection($this->getConnectionName())->getDatabaseName().'.'.$this->getTable();
        parent::__construct($attributes);
    }

    public function getConnectionName(): string
    {
        return Payment::dbConnectionName();
    }
}
