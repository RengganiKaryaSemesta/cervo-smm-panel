<?php

namespace App\Livewire\Admin\OtherServiceManagement;

use App\Enums\SmmProviderServiceType;
use App\Services\SmmProvider\ApiSmmProvider;
use Livewire\Component;
use App\Models\SmmProvider;
use Illuminate\Support\Facades\Cache;

class Form extends Component
{
    public SmmProvider $smmProvider;
    public             $service;
    public             $form        = [
        'order',
    ];
    public function mount($code, $serviceId)
    {
        $this->smmProvider = SmmProvider::where(
            'code',
            $code
        )->firstOrFail();
        $cacheKey          = 'api_smm_provider_service_process_' . $this->smmProvider->code;
        $result            = Cache::get($cacheKey);
        if ($result == null) {
            return abort(404);
        }
        $searcService  = $result->filter(fn ($data) => $data->service == $serviceId);
        $this->service = $searcService->flatMap(
            fn ($data) => [
                'service'  => $data->service,
                'name'     => $data->name,
                'type'     => SmmProviderServiceType::from($data->type),
                'category' => $data->category,
                'rate'     => $data->rate,
                'cancel'   => $data->cancel,
                'min'      => $data->min,
                'max'      => $data->max,
                'refill'   => $data->refill,
            ]
        );
    }
    public function render()
    {
        return view(
            'livewire.admin.other-service-management.form',
            [
                'balance' => (new ApiSmmProvider(
                    $this->smmProvider->api_url,
                    $this->smmProvider->api_key
                ))->balance(),
            ]
        )->title('Other Services - Order')->layout('layouts.admin.app');
    }
}
