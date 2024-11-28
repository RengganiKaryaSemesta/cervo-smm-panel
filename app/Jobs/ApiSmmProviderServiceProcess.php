<?php

namespace App\Jobs;

use Cache;
use App\Models\SmmProvider;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\SmmProvider\ApiSmmProvider;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ApiSmmProviderServiceProcess implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $timeout = 300;
    public function __construct(public SmmProvider $smmProvider)
    {
        //
    }
    public function uniqueId(): string
    {
        return $this->smmProvider->code;
    }
    /**
     * Execute the job.
     */
    public function handle() : void
    {
        $cacheKey = 'api_smm_provider_service_process_' . $this->smmProvider->code;
        if (cache()->has($cacheKey)) {
            return;
        }
        $services = (new ApiSmmProvider(
            $this->smmProvider->api_url,
            $this->smmProvider->api_key
        ))->services();
        Cache::put(
            $cacheKey,
            $services,
            now()->addMinutes(10)
        );
    }
}
