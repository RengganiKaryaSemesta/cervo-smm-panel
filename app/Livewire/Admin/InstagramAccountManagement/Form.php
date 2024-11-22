<?php

namespace App\Livewire\Admin\InstagramAccountManagement;

use Livewire\Component;

class Form extends Component
{
    public $username, $email, $password, $cookie, $status;

    public function render()
    {
        return view('livewire.admin.instagram-account-management.form');
    }
}
