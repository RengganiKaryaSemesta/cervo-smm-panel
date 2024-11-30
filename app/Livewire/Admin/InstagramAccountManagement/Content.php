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
            $data            = InstagramAccount::findOrFail($id);
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
        return InstagramAccount::search($this->pagination['search'])
            ->byUser()->customFilters($this->pagination)
            ->customSingleOrders($this->pagination)
            ->withTrashed(auth()->user()->can('delete instagram account management'))
            ->when(
                isset($this->pagination["filters_status"]) && $this->pagination["filters_status"],
                function ($query) {
                    return $query->where(
                        'status',
                        $this->pagination["filters_status"] == "active" ? 1 : 0);
                });
    }
    public function delete($id, $type)
    {
        try {
            $data = InstagramAccount::withTrashed()->whereIn(
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
                activity('Instagram Account Restore/Delete')
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
            'livewire.admin.instagram-account-management.content',
            [
                'data' => $this->getData()->paginate($this->pagination['limit'])->withQueryString(),
            ]
        )->title('Instagram Account Management')->layout('layouts.admin.app');
    }
}
