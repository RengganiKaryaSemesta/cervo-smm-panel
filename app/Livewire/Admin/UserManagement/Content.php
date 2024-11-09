<?php

namespace App\Livewire\Admin\UserManagement;

use App\Models\User;
use App\Traits\PaginationVariable;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Session;
use Livewire\Attributes\Computed;

class Content extends Component
{
    use WithPagination, PaginationVariable;

    public $formTitle;
    public function add()
    {
        $this->formTitle = 'Create a new User';
        $this->dispatch(
            'form-event',
            data: null
        );
        $this->dispatch(
            'offcanvascontroller',
            data: null
        );
    }
    public function edit($id)
    {
        try {
            $user            = User::with(
                ['roles' => function ($query) {
                    return $query->select('name');
                }]
            )->findOrFail($id);
            $this->formTitle = 'Edit User';
            $this->dispatch(
                'form-event',
                data: $user
            );
            $this->dispatch('offcanvascontroller');
        }
        catch (\Throwable $th) {
            $this->dispatch(
                'swal:error',
                message: $th->getMessage()
            )->self();
        }

    }
    #[On('offcanvascontrollerdismiss')]
    public function getUser()
    {
        return User::search($this->pagination['search'])->with(
            ['roles' => function ($query) {
                return $query->select('name');
            }]
        )->withTrashed()->latest()
            ->paginate($this->pagination['limit'])->withQueryString();
    }
    public function delete($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            if ($user->deleted_at !== null) {
                $user->deleted_at = null;
                $message          = "User {$user->name} telah berhasil di restored";

            }
            else {
                $message = "User {$user->name} telah berhasil di deleted";
                $user->delete();
            }
            $user->save();
            activity('User Restore/Delete')
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->log($message);
            $this->dispatch(
                'swal:success',
                message: $message
            )->self();
        }
        catch (\Throwable $th) {
            $this->dispatch(
                'swal:error',
                message: $th->getMessage()
            )->self();
        }
    }

    public function render()
    {
        return view(
            'livewire.admin.user-management.content',
            [
                'users' => $this->getUser(),
            ]
        )->title('User Management')->layout('layouts.admin.app');
    }
}
