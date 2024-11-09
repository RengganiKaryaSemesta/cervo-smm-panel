<?php

namespace App\Livewire\Admin\RoleManagement;

use Livewire\Component;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Form extends Component
{
    public $form = [
        'name' => '',
        'description' => '',
        'permissions' => []
    ];
    public $permissions;
    public function mount()
    {
        $this->permissions = Permission::get();
    }
    public function submit()
    {
        $validate = Validator::make($this->form, [
            'name' => 'required|unique:roles,name' . (isset($this->form['id']) ? ",{$this->form['id']}" : ''),
            'permissions' => 'required|min:1'
        ]);
        if (isset($this->form['id'])) {
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
            $role = Role::findOrFail($this->form['id']);
            $role->name = $this->form['name'];
            $role->description = $this->form['description'];
            $role->saveOrFail();
            $role->syncPermissions($this->form['permissions']);
            $this->dispatch('offcanvascontrollerdismiss');
            $message = "Role {$role->name} telah berhasil di updated";
            activity('Role updated')
                ->causedBy(auth()->user())
                ->performedOn($role)
                ->withProperties($this->form)
                ->log($message);
            $this->dispatch('swal:success', message: $message)->self();
            \DB::commit();
        } catch (\Throwable $th) {
            $this->dispatch('swal:error', message: $th->getMessage())->self();
        }
    }
    public function store($validate)
    {
        try {
            if ($validate->fails()) {
                return throw new \Exception($validate->errors()->first());
            }
            \DB::beginTransaction();
            $role = new Role;
            $role->name = $this->form['name'];
            $role->description = $this->form['description'];
            $role->saveOrFail();
            $role->syncPermissions($this->form['permissions']);
            $this->dispatch('offcanvascontrollerdismiss');
            $message = 'Successfully created a new role';
            activity('Role updated')
                ->causedBy(auth()->user())
                ->performedOn($role)
                ->withProperties($this->form)
                ->log($message);
            $this->dispatch('swal:success', message: $message)->self();
            \DB::commit();
        } catch (\Throwable $th) {
            $this->dispatch('swal:error', message: $th->getMessage())->self();
        }

    }
    #[On('form-event')]
    public function formEvent($data)
    {
        if ($data != null) {
            $data['permissions'] = collect($data['permissions'])->map(fn($perm) => $perm['name'])->toArray();
            $this->form = $data;
            return true;
        }
        $this->reset('form');
    }
    public function render()
    {
        return view('livewire.admin.role-management.form');
    }
}
