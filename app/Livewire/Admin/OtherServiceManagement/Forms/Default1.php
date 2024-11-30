<?php

namespace App\Livewire\Admin\OtherServiceManagement\Forms;

use Livewire\Component;
use App\Models\SmmProvider;
use App\Models\SmmProviderOrder;
use App\Services\SmmProvider\ApiSmmProvider;
use App\Services\SmmProvider\ProviderResolver;

class Default1 extends Component
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

            $this->form['interval'] = null;
            $this->form['runs']     = null;
            $this->form['service']  = $this->service['service'];

            \DB::beginTransaction();
            $apiSmmProvider = (new ProviderResolver)->resolve($this->smmProvider)->order($this->form);
            if (isset($apiSmmProvider['error'])) {
                return throw new \Exception($apiSmmProvider['error']);

            }
            $data                  = new SmmProviderOrder;
            $data->order_id        = $apiSmmProvider['order'];
            $data->smm_provider_id = $this->smmProvider->id;
            $data->target          = $this->form["link"];
            $data->service         = "[{$this->service['service']}] {$this->service['name']}";
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
    public function calculate()
    {
        $rate = $this->service['rate']; // Misalnya "12.000,00"

        // Proses konversi format
        $numericValue = str_replace(
            '.',
            '',
            $rate
        );
        $numericValue = str_replace(
            ',',
            '.',
            $numericValue
        );
        $numericValue = floatval($numericValue);
        $quantity     = intval(isset($this->form['quantity']) ? $this->form['quantity'] : 0);
        // Perhitungan
        $result = $numericValue * $quantity;

        return number_format(
            $result,
            2,
            ',',
            '.'
        );
    }
    public function render()
    {
        return view('livewire.admin.other-service-management.forms.default1');
    }
}
