<?php

namespace App\Livewire\Admin\RoleManagement;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Session;
use App\Traits\PaginationVariable;
use Spatie\Permission\Models\Role;

class Content extends Component
{
    use WithPagination, PaginationVariable;
    public $formTitle;
    public function add()
    {
        $this->formTitle = 'Create a new Role';
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
            $role            = Role::with('permissions')->findOrFail($id);
            $this->formTitle = 'Edit Role';
            $this->dispatch(
                'form-event',
                data: $role
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
    public function getRole()
    {
        return Role::where(
            'name',
            'LIKE',
            '%' . $this->pagination['search'] . '%'
        )->orWhere(
                'description',
                'LIKE',
                '%' . $this->pagination['search'] . '%'
            )->latest()
            ->paginate($this->pagination['limit'])->withQueryString();
    }
    public function delete($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            $message = "Role {$role->name} telah berhasil di deleted";
            activity('Role updated')
                ->causedBy(auth()->user())
                ->performedOn($role)
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
            'livewire.admin.role-management.content',
            [
                'roles' => $this->getRole(),
            ]
        )->title('Role Management')->layout('layouts.admin.app');
    }
}
