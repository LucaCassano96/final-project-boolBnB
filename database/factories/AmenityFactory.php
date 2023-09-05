<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Amenity>
 */
class AmenityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

                'title' => fake() -> unique() -> randomElement([
                "piscina", "sauna", "parcheggio gratuito", "WiFi", "aria condizionata", "vista mare", "TV", "lavatrice", "barbecue", "sala giochi"
            ]) ,
            'icon' => fake() ->imageUrl(70, 70, "icon", true),

        ];
    }
}
