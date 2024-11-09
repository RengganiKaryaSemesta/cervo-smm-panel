<?php

namespace App\Livewire\Admin\UserManagement;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    public $form  = [
        "name"                  => "",
        "email"                 => "",
        "password"              => "",
        "password_confirmation" => "",
        "username"              => "",
        "role"                  => "",
    ];
    public $roles = [];
    public function submit()
    {
        $validate = Validator::make(
            $this->form,
            [
                "name"     => "required",
                "email"    => "required|email|unique:users,email" . (isset($this->form["id"]) ? ",{$this->form["id"]}" : ""),
                "password" => isset($this->form["id"]) ? "confirmed" : "required|confirmed",
                "username" => "required|unique:users,username" . (isset($this->form["id"]) ? ",{$this->form["id"]}" : ""),
                "role"     => "required|exists:roles,name",
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
            $user           = User::findOrFail($this->form["id"]);
            $user->name     = $this->form["name"];
            $user->email    = $this->form["email"];
            $user->username = $this->form["username"];
            if ($this->form["password"] != null) {
                $user->password = Hash::make($this->form["password"]);
            }
            $user->saveOrFail();
            $user->syncRoles($this->form["role"]);
            $this->dispatch("offcanvascontrollerdismiss");
            $this->dispatch(
                "swal:success",
                message: "User {$user->name} telah berhasil di updated"
            )->self();
            activity("User Updated")
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties($this->form)
                ->log("User melakukan update");
            \DB::commit();
        }
        catch (\Throwable $th) {
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
            $user           = new User;
            $user->name     = $this->form["name"];
            $user->email    = $this->form["email"];
            $user->username = $this->form["username"];
            $user->password = Hash::make($this->form["password"]);
            $user->saveOrFail();
            $user->syncRoles($this->form["role"]);
            $this->dispatch("offcanvascontrollerdismiss");
            $this->dispatch(
                "swal:success",
                message: "Successfully created a new user"
            )->self();
            activity("User Created")
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties($this->form)
                ->log("Menambah user baru");
            \DB::commit();
        }
        catch (\Throwable $th) {
            $this->dispatch(
                "swal:error",
                message: $th->getMessage()
            )->self();
        }

    }
    #[On("getRoles")]
    public function getRoles(string $search = null, $defaultId = null)
    {
        $this->roles = Role::
            where(
                "name",
                "LIKE",
                "%" . $search . "%"
            )
            ->when(
                ! auth()->user()->hasRole("Super Admin"),
                function ($query) {
                    return $query->whereNot(
                        "name",
                        "Super Admin"
                    );
                }
            )
            ->when(
                $defaultId != null,
                fn ($q) => $q->orWhere(
                    "name",
                    $defaultId
                )
            )
            ->limit(10)->get()
            ->map(
                fn ($item) => [
                    "id"   => $item->name,
                    "name" => "$item->name <br/> <small>$item->description</small>",
                ]
            )->toArray();
        return $this->roles;
    }
    #[On("form-event")]
    public function formEvent($data)
    {
        if ($data != null) {
            $this->form             = $data;
            $this->form["password"] = "";
            $this->form["role"]     = collect($data["roles"])->first() ? collect($data["roles"])->first()["name"] : null;
            $this->getRoles(defaultId: $this->form["role"]);
            return true;
        }
        $this->getRoles();
        $this->reset("form");
    }
    public function render()
    {
        return view("livewire.admin.user-management.form");
    }
}
