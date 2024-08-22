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
            'card_number' => fake()->unique()->creditCardNumber,
            'pin' => static::$pin ??= Hash::make('1234'),
            'amount' => $this->roundNumber(fake()->numberBetween(100000, 6000000)),
            'description' => 'Expiration date: ' . fake()->creditCardExpirationDateString,
        ];
    }
    private function roundNumber($numero)
    {
        $primerDigito = substr($numero, 0, 1);
        $longitud = strlen($numero);
        return $primerDigito * pow(10, $longitud - 1);
    }
}
