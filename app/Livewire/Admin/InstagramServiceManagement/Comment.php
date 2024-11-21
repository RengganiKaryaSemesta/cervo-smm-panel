<?php

namespace App\Livewire\Admin\InstagramServiceManagement;

use Livewire\Component;
use App\Models\InstagramAccount;
use App\Models\InstagramService;
use App\Jobs\InstagramServiceJob;
use App\Enums\InstagramServiceType;
use App\Enums\InstagramServiceStatus;
use Illuminate\Support\Facades\Validator;

class Comment extends Component
{
    public $form = [
        'url'           => null,
        'account_count' => null,
        'type'          => null,
        'status'        => null,
        'started_at'    => null,
        'finished_at'   => null,
        'use_ai'        => false,
        'comments'      => ['Nice to meet u'],
    ];
    public function deleteComment($key)
    {
        unset($this->form['comments'][$key]);
        $this->form['comments'] = array_values($this->form['comments']);
    }
    public function setCommentFromAi($data)
    {
        $this->form['comments'] = array_values(array_merge(
            $data,
            $this->form['comments']
        ));
    }
    public function newComment()
    {
        $this->form['comments'][] = '';
    }
    public function submit()
    {
        $totalInstagramAccount = InstagramAccount::count();
        $validate              = Validator::make(
            $this->form,
            [
                'url'           => 'required|url',
                'account_count' => 'required|numeric|min:1|max:' . $totalInstagramAccount,
                'comments'      => 'array|min:1',
            ]
        );
        try {
            if ($validate->fails()) {
                return throw new \Exception($validate->errors()->first());
            }
            \DB::beginTransaction();
            $data = new InstagramService;
            $data->fill($this->form);
            $data->type        = InstagramServiceType::Comment->value;
            $data->status      = InstagramServiceStatus::InProgress->value;
            $data->started_at  = now();
            $data->finished_at = now();
            $data->saveOrFail();
            \DB::commit();
            InstagramServiceJob::dispatch(
                $data,
                $this->form['comments']
            );
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
        return view('livewire.admin.instagram-service-management.comment')->title('Service Instagram - Comments')->layout('layouts.admin.app');
    }
}
