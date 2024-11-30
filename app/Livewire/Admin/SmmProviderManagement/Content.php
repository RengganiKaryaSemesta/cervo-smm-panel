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
            data: NULL
        );
        $this->dispatch(
            'offcanvascontroller',
            data: NULL
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
        return SmmProvider::search($this->pagination['search'])
            ->customFilters($this->pagination)
            ->customSingleOrders($this->pagination)
            ->withTrashed(auth()->user()->can('delete smm provider management'));
    }
    public function delete($id, $type)
    {
        try {
            $data = SmmProvider::withTrashed()->whereIn(
                "id",
                is_array($id) ? $this->pagination["selecteds"] : [$id])->get();
            foreach ($data as $item) {
                if ($type === "Restore") {
                    $item->deleted_at = NULL;
                    $message          = "Data {$item->name} telah berhasil di restored";
                }
                else {
                    $message = "Data {$item->name} telah berhasil di deleted";
                    $item->delete();
                }
                $item->save();
                activity('SMM Provider Restore/Delete')
                    ->causedBy(auth()->user())
                    ->log($message);
            }
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
            'livewire.admin.smm-provider-management.content',
            ['data' => $this->getData()->paginate($this->pagination['limit'])->withQueryString()])->title('SMM Provider Management')->layout('layouts.admin.app');
    }
}
