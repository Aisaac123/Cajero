<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected static ?string $pin;

    public function definition(): array
    {
        return [
            'user_id' => 1,
            'type' => fake()->creditCardType,
            'card_number' => fake()->creditCardNumber,
            'pin' => static::$pin ??= Hash::make('1234'),
            'description' => 'Expiration date: ' . fake()->creditCardExpirationDateString,
        ];
    }
}
