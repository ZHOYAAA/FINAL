<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\page;
use App\Models\category;
use Illuminate\Support\Facades\Config;

class Login extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            if (auth()->user()->isAdmin()) {
                return redirect('/admin');
            }
            return redirect('/');
        }

        $this->addError('email', 'These credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}