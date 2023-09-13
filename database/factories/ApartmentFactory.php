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
            'picture' => fake() ->regexify(),
            'price' => fake() -> numberBetween(50, 1000),
            'visible' => fake() -> boolean(),
            'address' => fake() -> streetAddress(),
            'latitude' => fake() -> latitude($min = 35.0, $max = 47.0),
            'longitude' => fake() -> longitude($min = 6.0, $max = 18.0),

        ];
    }
}


