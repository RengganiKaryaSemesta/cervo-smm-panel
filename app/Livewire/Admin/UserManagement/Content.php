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
        $this->formTitle = "Create a new User";
        $this->dispatch(
            "form-event",
            data: NULL
        );
        $this->dispatch(
            "offcanvascontroller",
            data: NULL
        );
    }
    public function edit($id)
    {
        try {
            $user            = User::with(
                ["roles" => function ($query) {
                    return $query->select("name");
                }]
            )->findOrFail($id);
            $this->formTitle = "Edit User";
            $this->dispatch(
                "form-event",
                data: $user
            );
            $this->dispatch("offcanvascontroller");
        }
        catch (\Throwable $th) {
            $this->dispatch(
                "swal:error",
                message: $th->getMessage()
            )->self();
        }

    }
    #[On("offcanvascontrollerdismiss")]
    public function getData()
    {
        return User::search($this->pagination["search"])->with(
            ["roles" => function ($query) {
                return $query->select("name");
            }]
        )->withTrashed()->whereNot(
                "id",
                1)->latest();
    }
    public function delete($id, $type)
    {
        try {
            $data = User::withTrashed()->whereIn(
                "id",
                is_array($id) ? $this->pagination["selecteds"] : [$id])->get();
            foreach ($data as $value) {
                if ($type === "Restore") {
                    $value->deleted_at = NULL;
                    $message           = "User telah berhasil di restored";
                }
                else {
                    $message = "User telah berhasil di deleted";
                    $value->delete();
                }
                $value->save();
                activity("User Restore/Delete")
                    ->causedBy(auth()->user())
                    ->log($message);
            }
            $this->dispatch(
                "swal:success",
                message: $message
            );
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
        return view(
            "livewire.admin.user-management.content",
            [
                "users" => $this->getData()->paginate($this->pagination["limit"])->withQueryString(),
            ]
        )->title("User Management")->layout("layouts.admin.app");
    }
}
