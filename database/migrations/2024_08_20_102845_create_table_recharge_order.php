<?php

use App\Database\Blueprint;
use App\Database\PaymentCreateMigration;
use App\Enum\RechargeOrderStatus;


return new class extends PaymentCreateMigration
{
    /**
     * {@inheritDoc}
     */
    public function definition(Blueprint $table): void
    {
        $table->id();
        $table->foreignId('user_id')->constrained('user');
        $table->foreignId('product_id')->constrained('product');
        $table->unsignedInteger('amount');
        $table->char('status', 24)->default(RechargeOrderStatus::PENDING)->comment("Trạng thái xử lý đơn hàng");
        $table->json('payload')->nullable();
        $table->dateTime('expired_at')->nullable();

        $table->autoTimestamps();
    }

    /**
     * {@inheritDoc}
     */
    public function tableName(): string
    {
        return 'recharge_order';
    }
};
