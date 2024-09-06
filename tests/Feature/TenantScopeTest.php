<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Database\Factories\TenantFactory;
use Database\Factories\UserFactory;
use Dotenv\Util\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * The Tenant scope testing.
 */
class TenantScopeTest extends TestCase {

  use RefreshDatabase, WithFaker;

  /**
   * @test
   */
  public function a_model_has_tenant_id_on_the_migration() {
    // Create dummmy model.
    $filename = now()->format('Y_m_d_His') . '_create_tests_table.php';
    $this->artisan('make:model Test -m');
    // Check the migration file for tenant_id.
    $this->assertTrue(File::exists(database_path('migrations/' . $filename)));
    // Check if stub contains the tenant_id column.
    $this->assertStringContainsString('$table->unsignedBigInteger(\'tenant_id\')->index();', File::get(database_path('migrations/' . $filename)));

    // Delete created files.
    File::delete(database_path('migrations/' . $filename));
    File::delete(app_path('Models/Test.php'));
  }

  /**
   * @test
   */
  public function a_user_can_only_see_users_in_the_same_tentant() {
    $tenant_1 = Tenant::factory()->create(['name' => 'first']);
    $tenant_2 = Tenant::factory()->create(['name' => 'second']);

    // Create a tested user with the tenant_1.
    $user_1 =  User::factory()->create([
      'tenant_id' => $tenant_1,
    ]);

    // Create a other users with the tenant_1.
    User::factory(9)->create([
      'tenant_id' => $tenant_1,
    ]);

    // Create a other users with the tenant_2.
    User::factory(10)->create([
      'tenant_id' => $tenant_2,
    ]);

    // Login as a tested user.
    auth()->login($user_1);
    $this->actingAs($user_1);

    // Assert count of visible users. Expected to be 1 + 9.
    $this->assertEquals(10, User::count());
  }

  /**
   * @test
   */
  public function a_user_can_only_create_a_user_in_his_tenant() {
    $tenant_1 = Tenant::factory()->create(['name' => 'first']);
    $tenant_2 = Tenant::factory()->create(['name' => 'second']);

    // Create a tested user with the tenant_1.
    $user_1 =  User::factory()->create([
      'tenant_id' => $tenant_1,
    ]);

    // Login as a tested user.
    auth()->login($user_1);
    $this->actingAs($user_1);

    $created_user = User::factory()->create();

    $this->assertTrue($created_user->tenant_id === $user_1->tenant_id);
  }

  /**
   * @test
   */
  public function a_user_can_only_create_a_user_in_his_tenant_even_anothe_tenant_provided() {
    $tenant_1 = Tenant::factory()->create(['name' => 'first']);
    $tenant_2 = Tenant::factory()->create(['name' => 'second']);

    // Create a tested user with the tenant_1.
    $user_1 =  User::factory()->create([
      'tenant_id' => $tenant_1,
    ]);

    // Login as a tested user.
    auth()->login($user_1);
    $this->actingAs($user_1);

    $created_user = User::factory()->make();
    $created_user->tenant_id = $tenant_2->id;
    $created_user->save();

    // check if created user with wron tenant has correct tenant.
    $this->assertTrue($created_user->tenant_id === $user_1->tenant_id);
  }

}
