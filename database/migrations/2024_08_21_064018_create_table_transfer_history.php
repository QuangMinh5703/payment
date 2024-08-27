<?php

use App\Database\PaymentCreateMigration;
use App\Enum\TransferHistoryStatus;

return new class extends PaymentCreateMigration
{
    /**
     * {@inheritDoc}
    */
    public function definition(\App\Database\Blueprint $table): void
    {
        $table->id();
        $table->unsignedInteger('order_id');
        $table->string('title');
        $table->longText('content');
        $table->char('content_sign', 32)->index();
        $table->char('status', 16)->default(TransferHistoryStatus::NEW->value)->index();
        $table->json('metadata')->nullable();
        $table->dateTime('received_at');
        $table->autoTimestamps();
    }

    /**
     * {@inheritDoc}
     */
    public function tableName(): string
    {
        return 'transfer_history';
    }
};
