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
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();

        $table->autoTimestamps();
    }

    /**
     * {@inheritDoc}
     */
    public function tableName(): string
    {
        return 'user';
    }
};
