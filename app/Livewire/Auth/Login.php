<?php

namespace App\Livewire\Auth;

use App\Mail\OtpLoginMail;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title("Login")]
class Login extends Component
{
    public                          $email_or_username = "", $password          = "";
    public function save()
    {
        $field = filter_var(
            $this->email_or_username,
            FILTER_VALIDATE_EMAIL
        ) ? 'email' : 'username';

        // Attempt to authenticate the user
        $credentials = [
            $field     => $this->email_or_username,
            'password' => $this->password,
        ];
        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }
        else {
            session()->flash(
                'status',
                'Invalid credentials. Please try again.'
            );
            return redirect()->back();
        }
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
