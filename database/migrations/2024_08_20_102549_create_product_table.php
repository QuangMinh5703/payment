<?php

use App\Database\PaymentCreateMigration;
use App\Database\Blueprint;

return new class extends PaymentCreateMigration
{
    /**
     * {@inheritDoc}
     */
    public function definition(Blueprint $table): void
    {
        $table->id();
        $table->char('code', 32)->unique();
        $table->string('name');
        $table->mediumText('description');
        $table->json('metadata')->nullable();

        $table->autoTimestamps();
    }

    /**
     * {@inheritDoc}
     */
    public function tableName(): string
    {
        return 'product';
    }
};
