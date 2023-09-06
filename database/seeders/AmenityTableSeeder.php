<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Amenity;
use App\Models\Apartment;


class AmenityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $amenities =  Amenity :: factory() -> count(10) -> create();

        foreach ($amenities as $amenity) {

        $apartments = Apartment :: inRandomOrder() -> limit(rand(1,10)) -> get();

        $amenity -> apartments() -> attach($apartments);

    }
    }
}
