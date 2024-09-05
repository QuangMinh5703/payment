<?php

namespace App\Job;

use App\Enum\RechargeOrderStatus;
use App\Models\RechargeOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(){

    }
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
