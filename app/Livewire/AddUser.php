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

  public $application;

  public function submit() {
    $this->validate([
      'name' => 'required|string',
      'email' => 'required|email|unique:users',
      'department' => 'required|string',
      'title' => 'required|string',
      'status' => 'required|boolean',
      'role' => 'required|string',
      'photo' => 'image|max:10000',
      'application' => 'file|mimes:pdf|max:10000',
    ]);

    $photo = $this->photo->store('photos', 's3');

    $user = User::create([
      'name' => $this->name,
      'email' => $this->email,
      'department' => $this->department,
      'title' => $this->title,
      'status' => $this->status,
      'role' => $this->role,
      'photo' => $photo,
      'password' => Str::random(16),
    ]);

    // Get file name.
    $filename = pathinfo($this->application->getClientOriginalName(), PATHINFO_FILENAME) . '_' . now()->timestamp . '.' . $this->application->getClientOriginalExtension();
    $directory_name = '/documents/' . $user->id . '/';

    // Store on s3.
    $document = $this->application->storeAs($directory_name, $filename, 's3-private');

    // Create document in db.
    $user->documents()->create([
      'type' => 'application',
      'filename' => $filename,
      'extension' => $this->application->getClientOriginalExtension(),
      'size' => $this->application->getSize(),
    ]);


    session()->flash('success', 'User sucecssfully created!');

    return redirect()->route('team.index');
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
