<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sponsor::factory() -> count(3)
         -> sequence(
            ['title' => 'Silver', 'price' => 2.99, 'duration' => 24],
            ['title' => 'Gold', 'price' => 5.99, 'duration' => 72],
            ['title' => 'Platinum', 'price' => 9.99, 'duration' => 144]
         )  -> create();
    }
}
