<?php

namespace App\Livewire;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUsers extends Component {

  use WithPagination;

  public int $perPage = 10;

  public string $sortField = 'name';

  public bool $sortAsc = TRUE;

  public string $search = '';

  public bool $super;

  public array|Collection $tenants;

  public $selectedTenant;

  public function sortBy($field) {
    if ($this->sortField === $field) {
      $this->sortAsc = !$this->sortAsc;
    }
    else {
      $this->sortAsc = TRUE;
    }

    $this->sortField = $field;
  }

  public function mount() {
    if (session()->has('tenant_id')) {
      $this->super = FALSE;
    }
    else {
      $this->super = TRUE;
      $this->tenants = Tenant::all()->pluck('name', 'id')->toArray();
    }
  }

  public function render() {
    $query = User::search($this->search)
      ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

    if ($this->super && $this->selectedTenant) {
      $query->where('tenant_id', $this->selectedTenant);
    }

    return view('livewire.show-users', [
      'users' => $query->with('documents')->paginate($this->perPage),
    ]);
  }

  public function impersonate(int $uid) {
    if (!is_null(Auth::user()->tenant_id) || strtolower(Auth::user()->role) !== 'admin') {
      return;
    }
    if ($uid !== (int) Auth::user()->id) {
      session()->put('impersonate', Auth::user()->id);
      Auth::loginUsingId($uid);
    }

    return redirect()->back();
  }

}
