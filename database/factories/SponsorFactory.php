<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsor>
 */
class SponsorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'title' => "abbonamento" ,
            'price' => fake() -> unique() -> randomElement(["2,99", "5,99", "9,99"]),
            'duration' => fake() -> unique() -> randomElement([24, 72, 144])
        ];
    }
}
