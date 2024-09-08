<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

  /**
   * Seed the application's database.
   */
  public function run(): void {
    User::factory()->create([
      'name' => 'Admin',
      'email' => 'admin@example.com',
      'password' => '123123123',
      'tenant_id' => NULL,
    ]);

    $this->call(DemoSeeder::class);
  }

}
