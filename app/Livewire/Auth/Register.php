<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\page;
use App\Models\category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
    ];

    public function register()
{
    $this->validate();

    User::create([
        'name' => $this->name,
        'email' => $this->email,
        'password' => Hash::make($this->password),
        'role' => 'user'
    ]);

    $this->reset(['name', 'email', 'password', 'password_confirmation']);
    $this->dispatch('close-modal', [
        'modal' => 'registerModal'
    ]);

    session()->flash('success', 'Registration successful! Please login.');
    return redirect('/login');  // Redirect ke login user
}
}