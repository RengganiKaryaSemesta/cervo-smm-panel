<?php

namespace App\Livewire\Admin\SmmProviderManagement;

use Livewire\Component;
use App\Models\SmmProvider;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Validator;

class Form extends Component
{
    public $form = [
        "name"    => "",
        "api_url" => "",
        "api_key" => "",
    ];
    public function submit()
    {
        $validate = Validator::make(
            $this->form,
            [
                "name"    => "required",
                "api_url" => "url|required",
                "api_key" => "required",
            ]
        );
        if (isset($this->form["id"])) {
            return $this->update($validate);
        }
        return $this->store($validate);
    }
    public function update($validate)
    {
        try {
            if ($validate->fails()) {
                return throw new \Exception($validate->errors()->first());
            }
            \DB::beginTransaction();
            $data = SmmProvider::findOrFail($this->form["id"]);
            $data->fill($this->form);
            $data->saveOrFail();
            $this->dispatch("offcanvascontrollerdismiss");
            $this->dispatch(
                "swal:success",
                message: "Smm Provider {$data->username} Update data success!"
            )->self();
            activity("Smm Provider Updated")
                ->causedBy(auth()->user())
                ->performedOn($data)
                ->withProperties($this->form)
                ->log("User melakukan update Smm Provider");
            \DB::commit();
        }
        catch (\Throwable $th) {
            $this->dispatch(
                "swal:error",
                message: $th->getMessage()
            )->self();
        }
    }
    public function store($validate)
    {
        try {
            if ($validate->fails()) {
                return throw new \Exception($validate->errors()->first());
            }
            \DB::beginTransaction();
            $data = new SmmProvider;
            $data->fill($this->form);
            $data->saveOrFail();
            $this->dispatch("offcanvascontrollerdismiss");
            $this->dispatch(
                "swal:success",
                message: "Successfully created a new data"
            )->self();
            activity("Smm Provider Create")
                ->causedBy(auth()->user())
                ->performedOn($data)
                ->withProperties($this->form)
                ->log("Successfully created a new data");
            \DB::commit();
        }
        catch (\Throwable $th) {
            $this->dispatch(
                "swal:error",
                message: $th->getMessage()
            )->self();
        }

    }

    #[On("form-event")]
    public function formEvent($data)
    {
        if ($data != null) {
            $this->form = $data;
            return true;
        }
        $this->reset("form");
    }
    public function render()
    {
        return view('livewire.admin.smm-provider-management.form');
    }
}
