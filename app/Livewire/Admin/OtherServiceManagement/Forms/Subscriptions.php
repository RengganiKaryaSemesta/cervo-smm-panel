<?php

namespace App\Livewire\Admin\OtherServiceManagement\Forms;

use App\Models\SmmProvider;
use App\Models\SmmProviderOrder;
use App\Services\SmmProvider\ApiSmmProvider;
use Livewire\Component;

class Subscriptions extends Component
{
    public SmmProvider $smmProvider;
    public             $service,   $form        = [
        'old_post'=>0
    ];
    public function submit()
    {
        $validate = \Illuminate\Support\Facades\Validator::make(
            $this->form,
            [
                'username'  => 'required',
                'min'       => 'required|numeric|min:' . $this->service['min'],
                'max'       => 'required|numeric|max:' . $this->service['max'],
                'posts'     => 'nullable',
                'old_posts' => 'nullable',
                'delay'     => 'nullable',
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

            $this->form['delay']   = 0;
            $this->form['service'] = $this->service['service'];
            $apiSmmProvider        = (new ApiSmmProvider(
                $this->smmProvider->api_url,
                $this->smmProvider->api_key
            ))->order($this->form);
            \DB::beginTransaction();
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
        return view('livewire.admin.other-service-management.forms.subscriptions');
    }
}
