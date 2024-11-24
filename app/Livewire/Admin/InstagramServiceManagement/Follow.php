<?php

namespace App\Livewire\Admin\InstagramServiceManagement;

use Livewire\Component;
use App\Models\InstagramAccount;
use App\Models\InstagramService;
use App\Jobs\InstagramServiceJob;
use App\Enums\InstagramServiceType;
use App\Enums\InstagramServiceStatus;
use Illuminate\Support\Facades\Validator;

class Follow extends Component
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
            $data->type        = InstagramServiceType::Follow->value;
            $data->status      = InstagramServiceStatus::InProgress->value;
            $data->started_at  = now();
            $data->finished_at = now();
            $data->saveOrFail();
            \DB::commit();
            // InstagramServiceJob::dispatch($data);
            $instagramServiceProcess = new \App\Services\Instagram\InstagramService;
            $instagramServiceProcess->comment(
                $data,
                ['ss']
            );
            dd($instagramServiceProcess);
            $this->dispatch("offcanvascontrollerdismiss");
            $this->dispatch(
                "swal:success",
                message: "The process is in progress, please check periodically in the report"
            )->self();
            activity("Instagram Service - Follow")
                ->causedBy(auth()->user())
                ->performedOn($data)
                ->withProperties($this->form)
                ->log("Membuat Layanan Instagram - Follow Berhasil");
            $this->reset();
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
        return view('livewire.admin.instagram-service-management.follow')->title('Service Instagram - Follow')->layout('layouts.admin.app');
    }
}
