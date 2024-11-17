<?php

namespace App\Livewire\Admin\InstagramAccountManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InstagramAccount;

class Content extends Component
{
    use WithPagination;

    public $formTitle;
    public $username, $name, $email, $password, $cookie, $status;
    protected $rules = [
        'username' => 'required|string|max:255',
        'name'     => 'nullable|string|max:255',
        'email'    => 'required|email|unique:instagram_accounts,email',
        'password' => 'required|string',
        'cookie'   => 'required|string',
        'status'   => 'required|boolean',
    ];
    public function add()
    {
        $this->resetFields();
        $this->formTitle = 'Create a new Instagram Account';
        $this->dispatch('form-event');
        $this->dispatch('offcanvascontroller');
    }

    public function edit($id)
    {
        try {
            $account = InstagramAccount::findOrFail($id);
            $this->username = $account->username;
            $this->name = $account->name;
            $this->email = $account->email;
            $this->password = $account->password;
            $this->cookie = $account->cookie;
            $this->status = $account->status;
            $this->formTitle = 'Edit Instagram Account';
            $this->dispatch('form-event');
            $this->dispatch('offcanvascontroller');
        } catch (\Throwable $th) {
            $this->dispatch('swal:error', message: $th->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->id) {
                $account = InstagramAccount::findOrFail($this->id);
                $account->update($this->data());
            } else {
                InstagramAccount::create($this->data());
            }
            $this->dispatch('swal:success', message: 'Instagram account saved successfully.');
            $this->resetFields();
            $this->dispatch('offcanvascontroller');
        } catch (\Throwable $th) {
            $this->dispatch('swal:error', message: $th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $account = InstagramAccount::findOrFail($id);
            $account->delete();
            $this->dispatch('swal:success', message: 'Instagram account deleted successfully.');
        } catch (\Throwable $th) {
            $this->dispatch('swal:error', message: $th->getMessage());
        }
    }

    private function resetFields()
    {
        $this->reset(['username', 'name', 'email', 'password', 'cookie', 'status']);
    }

    public function data()
    {
        return [
            'username' => $this->username,
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
            'cookie'   => $this->cookie,
            'status'   => $this->status,
        ];
    }

    public function render()
    {
        return view('livewire.admin.instagram-account-management.content', [
            'accounts' => InstagramAccount::latest()->paginate(10),
        ])->layout('layouts.admin.app');
    }
}
