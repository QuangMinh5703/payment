<?php

use App\Database\PaymentCreateMigration;
use App\Database\Blueprint;
use App\Enum\PaymentMethodStatus;

return new class extends PaymentCreateMigration
{
    /**
     * {@inheritDoc}
     */
    public function definition(Blueprint $table): void
    {
        $table->id();
        $table->char('type', 32)->index();
        $table->char('code', 32)->unique();
        $table->string('name', 128);
        $table->text('description')->nullable()->comment('Use to write recharge instructions');
        $table->char('status', 24)->default(PaymentMethodStatus::ACTIVE->value);
        $table->json('metadata')->nullable();
        $table->dateTime('closed_at')->nullable();
        $table->timestamp('last_maintenance_at')->nullable();
        $table->autoTimestamps();

        $table->unique(['name', 'type']);
    }

    /**
     * {@inheritDoc}
     */
    public function tableName(): string
    {
        return 'payment_method';
    }
};
