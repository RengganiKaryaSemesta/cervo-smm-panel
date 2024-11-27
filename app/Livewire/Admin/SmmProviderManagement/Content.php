<?php

namespace App\Livewire\Admin\SmmProviderManagement;

use App\Models\SmmProvider;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Traits\PaginationVariable;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

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
            $data            = SmmProvider::findOrFail($id);
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
        return SmmProvider::search($this->pagination['search'])->latest()
            ->withTrashed(auth()->user()->can('delete smm provider management'))
            ->paginate($this->pagination['limit'])->withQueryString();
    }
    public function delete($id)
    {
        try {
            $data = SmmProvider::withTrashed()->findOrFail($id);
            if ($data->deleted_at !== null) {
                $data->deleted_at = null;
                $message          = "Data {$data->name} telah berhasil di restored";

            }
            else {
                $message = "Data {$data->name} telah berhasil di deleted";
                $data->delete();
            }
            $data->save();
            activity('Instagram Account Restore/Delete')
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
        return view('livewire.admin.smm-provider-management.content',['data'=>$this->getData()])->title('SMM Provider Management')->layout('layouts.admin.app');
    }
}
