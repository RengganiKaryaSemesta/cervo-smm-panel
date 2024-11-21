<?php

namespace App\Livewire\Admin\InstagramServiceManagement;

use App\Enums\InstagramServiceStatus;
use App\Enums\InstagramServiceType;
use App\Models\InstagramAccount;
use App\Models\InstagramService;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Like extends Component
{
    public $form = [
        'url'           => null,
        'account_count' => null,
        'type'          => null,
        'status'        => null,
        'started_at'    => null,
        'finished_at'   => null,
    ];
    public function submit()
    {
        $totalInstagramAccount = InstagramAccount::count();
        $validate              = Validator::make(
            $this->form,
            [
                'url'           => 'required|url',
                'account_count' => 'required|numeric|min:1|max:' . $totalInstagramAccount,
            ]
        );
        try {
            if ($validate->fails()) {
                return throw new \Exception($validate->errors()->first());
            }
            \DB::beginTransaction();
            $data = new InstagramService;
            $data->fill($this->form);
            $data->type        = InstagramServiceType::Like->value;
            $data->status      = InstagramServiceStatus::InProgress->value;
            $data->started_at  = now();
            $data->finished_at = now();
            $data->saveOrFail();
            $this->dispatch("offcanvascontrollerdismiss");
            $this->dispatch(
                "swal:success",
                message: "The process is in progress, please check periodically in the report"
            )->self();
            activity("Instagram Account")
                ->causedBy(auth()->user())
                ->performedOn($data)
                ->withProperties($this->form)
                ->log("Create Instagram Account");
            \DB::commit();
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
        return view('livewire.admin.instagram-service-management.like')->title('Service Instagram - Like')->layout('layouts.admin.app');
    }
}
