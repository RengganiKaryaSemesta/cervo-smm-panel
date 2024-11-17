<?php

namespace App\Livewire\Admin\InstagramAccountManagement;

use App\Models\InstagramAccount;
use Livewire\Attributes\On;
use Livewire\Component;
use Validator;

class Form extends Component
{
    public $form = [
        "username" => "",
        "email" => "",
        "password" => "",
        "cookie" => "",
    ];
    public function submit()
    {
        $validate = Validator::make(
            $this->form,
            [
                "email" => "required|email|unique:instagram_accounts,email" . (isset($this->form["id"]) ? ",{$this->form["id"]}" : ""),
                "password" => "required",
                "username" => "required|unique:instagram_accounts,username" . (isset($this->form["id"]) ? ",{$this->form["id"]}" : ""),
                "cookie" => "required",
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
            $data = InstagramAccount::findOrFail($this->form["id"]);
            $data->fill($this->form);
            $data->status = true;
            $data->saveOrFail();
            $this->dispatch("offcanvascontrollerdismiss");
            $this->dispatch(
                "swal:success",
                message: "Account {$data->username} Update data success!"
            )->self();
            activity("Account Instagram Updated")
                ->causedBy(auth()->user())
                ->performedOn($data)
                ->withProperties($this->form)
                ->log("User melakukan update Account instagram");
            \DB::commit();
        } catch (\Throwable $th) {
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
            $data = new InstagramAccount;
            $data->fill($this->form);
            $data->status = true;
            $data->saveOrFail();
            $this->dispatch("offcanvascontrollerdismiss");
            $this->dispatch(
                "swal:success",
                message: "Successfully created a new data"
            )->self();
            activity("Instagram Account")
                ->causedBy(auth()->user())
                ->performedOn($data)
                ->withProperties($this->form)
                ->log("Create Account Instagram");
            \DB::commit();
        } catch (\Throwable $th) {
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
        return view('livewire.admin.instagram-account-management.form');
    }
}
