<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apartment>
 */
class ApartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'title' => "apartment ".fake() -> word(),
            'description' => fake() -> paragraphs(2, true),
            'rooms' => fake() -> randomDigitNotNull(),
            'beds' => fake() -> randomDigitNotNull(),
            'bathrooms' => fake() -> randomDigitNotNull(),
            'square_meters' => fake() -> numberBetween(20, 500),
            'picture' => fake() -> imageUrl(360, 360, "house", true),
            'price' => fake() -> numberBetween(100, 1000000),
            'visible' => fake() -> boolean(),
            'address' => fake() -> streetAddress(),
            'latitude' => fake() -> latitude(),
            'longitude' => fake() -> longitude(),

        ];
    }
}


