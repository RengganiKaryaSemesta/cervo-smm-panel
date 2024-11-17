<?php

namespace App\Livewire\Admin\InstagramAccountManagement;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\InstagramAccount;
use App\Traits\PaginationVariable;

class Content extends Component
{
    use WithPagination, PaginationVariable;
    public $formTitle;
    public function add()
    {
        $this->formTitle = 'Create a new Data';
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
            $data            = InstagramAccount::with('permissions')->findOrFail($id);
            $this->formTitle = 'Edit Data';
            $this->dispatch(
                'form-event',
                data: $data
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
    public function getData()
    {
        return InstagramAccount::search($this->pagination['search'])->latest()
            ->paginate($this->pagination['limit'])->withQueryString();
    }
    public function delete($id)
    {
        try {
            $data = InstagramAccount::withTrashed()->findOrFail($id);
            if ($data->deleted_at !== null) {
                $data->deleted_at = null;
                $message          = "Data {$data->name} telah berhasil di restored";

            }
            else {
                $message = "Data {$data->name} telah berhasil di deleted";
                $data->delete();
            }
            $data->save();
            activity('User Restore/Delete')
                ->causedBy(auth()->user())
                ->performedOn($data)
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
            'livewire.admin.instagram-account-management.content',
            [
                'data' => $this->getData(),
            ]
        )->title('Role Management')->layout('layouts.admin.app');
    }
}
