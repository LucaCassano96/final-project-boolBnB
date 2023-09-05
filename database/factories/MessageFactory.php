<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'content' => "Hello ".fake() -> paragraph(),
            'sender_email' => fake() -> email(),
            'sender_name' => fake() -> firstName(),
            'sender_surname' => fake() -> lastName(),
        ];
    }
}
