<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddUser extends Component {

  use WithFileUploads;

  public $name = "Jogh Doe";

  public $email = "email@example.com";

  public $department = 'information_technology';

  public $title = "Instructor";

  #[Validate('image|max:10000')]
  public $photo;

  public $status = 1;

  public $role = 'admin';

  public function submit() {
    $this->validate([
      'name' => 'required|string',
      'email' => 'required|email|unique:users',
      'department' => 'required|string',
      'title' => 'required|string',
      'status' => 'required|boolean',
      'role' => 'required|string',
      'photo' => 'image|max:10000',
    ]);

    $filename = $this->photo->store('photos', 's3');

    User::create([
      'name' => $this->name,
      'email' => $this->email,
      'department' => $this->department,
      'title' => $this->title,
      'status' => $this->status,
      'role' => $this->role,
      'photo' => $filename,
      'password' => Str::random(16),
    ]);

    session()->flash('success', 'User sucecssfully created!');
  }

  /**
   * Renders the component.
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
   */
  public function render() {
    return view('livewire.add-user');
  }

}
