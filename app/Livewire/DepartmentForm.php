<?php

namespace app\Livewire;

use App\Models\Department;
use Livewire\Component;

class DepartmentForm extends Component {

  public string $name = 'Accounting';

  public bool $success = FALSE;

  public function submit() {
    Department::create([
      'name' => $this->name
    ]);
    $this->success = TRUE;
  }

  public function mount(int $department_id = NULL) {
    if ($department_id) {
      $this->name = Department::findOrFail($department_id)->name;
    }
  }

  public function render() {
    return view('livewire.department-form');
  }

}
