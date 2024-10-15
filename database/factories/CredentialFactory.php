<?php

namespace Database\Factories;

use App\CredentialType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Credential>
 */
class CredentialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
            'type' => [
                'type' => CredentialType::Bearer_Auth,
                'prefix' => 'Bearer',
            ],
            'value' => $this->faker->uuid(),
            'user_id' => User::factory(),
        ];
    }
}
