<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phone>
 */
class LoginFactory extends Factory {

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array {
    $randomDateTime = fake()->dateTimeBetween('-6 hours', 'now');

    return [
      'user_id' => User::factory(),
      'tenant_id' => User::factory(),
      'created_at' => $randomDateTime,
      'updated_at' => $randomDateTime,
    ];
  }

}
