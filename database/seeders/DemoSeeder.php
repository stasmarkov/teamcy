<?php

namespace Database\Seeders;

use App\Models\Login;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    Tenant::factory(3)->create();

    foreach (Tenant::all() as $tenant) {
      User::factory(20)->create([
        'tenant_id' => $tenant->id,
      ]);
    }

    foreach (User::all()->where('tenant_id', '!=', NULL) as $user) {
      Login::factory(5)->create([
        'user_id' => $user->id,
        'tenant_id' => $user->tenant_id,
      ]);
    }
  }

}
