<?php

namespace App\Command;

use App\Enum\RechargeOrderStatus;
use App\Models\RechargeOrder;
use Illuminate\Console\Command;

class RechargeOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of expired orders';

    public function handle(): void
    {
        RechargeOrder::where('status', RechargeOrderStatus::PENDING)
            ->where('expired_at', '<=', now())
            ->chunkById(100, function ($orders) {
                foreach ($orders as $order) {
                    $order->update(['status' => RechargeOrderStatus::FAILED]);
                }
            });
    }
}
