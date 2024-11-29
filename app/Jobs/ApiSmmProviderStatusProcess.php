<?php

namespace App\Jobs;

use App\Models\SmmProvider;
use App\Models\SmmProviderOrder;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\SmmProvider\ApiSmmProvider;

class ApiSmmProviderStatusProcess implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $timeout = 500;
    /**
     * Execute the job.
     */
    public function handle() : void
    {
        $smmProviders = SmmProvider::with('orders')->whereHas('orders')->get();
        $smmProviders->each(
            function ($smmProvider) {
                $orderIds       = $smmProvider->orders?->pluck('order_id')->toArray();
                $apiSmmProvider = (new ApiSmmProvider(
                    $smmProvider->api_url,
                    $smmProvider->api_key
                ))->multiStatus($orderIds);
                foreach ($apiSmmProvider as $key => $value) {
                    $order = SmmProviderOrder::where(
                        'order_id',
                        $key
                    )->first();
                    if ($order) {
                        $order->update(
                            [
                                'charge'      => $value->charge,
                                'start_count' => $value->start_count,
                                'status'      => $value->status,
                                'remains'     => $value->remains,
                            ]
                        );
                    }
                }
            }
        );
    }
}
