<?php

namespace App\Livewire\Admin\OtherServiceManagement\Forms;

use Livewire\Component;
use App\Models\SmmProvider;
use App\Models\SmmProviderOrder;
use App\Services\SmmProvider\ApiSmmProvider;

class Package extends Component
{
    public SmmProvider $smmProvider;
    public             $service,   $form        = [];
    public function submit()
    {
        $validate = \Illuminate\Support\Facades\Validator::make(
            $this->form,
            [
                'link'     => 'required|url',
                'quantity' => 'required|numeric|min:' . $this->service['min'],
            ]
        );
        return $this->store($validate);
    }
    public function store($validate)
    {
        try {
            if ($validate->fails()) {
                return throw new \Exception($validate->errors()->first());
            }
            $this->form['service']  = $this->service['service'];
            \DB::beginTransaction();
            $apiSmmProvider = (new ApiSmmProvider(
                $this->smmProvider->api_url,
                $this->smmProvider->api_key
            ))->order($this->form);
            if (isset($apiSmmProvider['error'])) {
                return throw new \Exception($apiSmmProvider['error']);

            }
            $data                  = new SmmProviderOrder;
            $data->order_id        = $apiSmmProvider['order'];
            $data->smm_provider_id = $this->smmProvider->id;
            $data->saveOrFail();
            $this->dispatch("offcanvascontrollerdismiss");
            $message = "Order Service - [{$this->service['service']}] {$this->service['name']}";
            $this->dispatch(
                "swal:success",
                message: $message
            )->self();
            activity("Other Service - Order")
                ->causedBy(auth()->user())
                ->performedOn($data)
                ->withProperties($this->form)
                ->log($message);
            \DB::commit();
            $this->reset('form');
        }
        catch (\Throwable $th) {
            $this->dispatch(
                "swal:error",
                message: $th->getMessage()
            )->self();
        }

    }
    public function render()
    {
        return view('livewire.admin.other-service-management.forms.package');
    }
}
