<?php

namespace App\Livewire\Auth;

use App\Models\Tenant;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component {

  /** @var string */
  public $name = '';

  /** @var string */
  public $email = '';

  /** @var string */
  public $password = '';

  /** @var string */
  public $companyName = '';

  public function register() {
    $this->validate([
      'name' => ['required', 'min:3'],
      'companyName' => ['required', 'string', 'unique:tenants,name', 'min:3'],
      'email' => ['required', 'email', 'unique:users'],
      'password' => ['required', 'min:8'],
    ]);

    $tenant = Tenant::create([
      'name' => $this->companyName,
    ]);

    $user = User::create([
      'email' => $this->email,
      'name' => $this->name,
      'password' => Hash::make($this->password),
      'role' => 'admin',
      'tenant_id' => $tenant->id,
    ]);

    event(new Registered($user));

    Auth::login($user, TRUE);

    return redirect()->intended(route('home'));
  }

  public function updated($field) {
    $this->resetErrorBag($field);
  }

  public function render() {
    return view('livewire.auth.register')->extends('layouts.auth');
  }

}
