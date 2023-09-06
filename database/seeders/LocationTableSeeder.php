<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\Apartment;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         /* UNO > UNO un appartamento per una location  */

        $apartments = Apartment :: all();
        $locations = Location :: factory() -> count(count($apartments)) -> make();

        for ($x=0;$x<count($apartments);$x++) {

            $apartment = $apartments[$x];
            $location = $locations[$x];

            $location -> apartment_id = $apartment -> id;
            $location -> save();
        }
    }
}
