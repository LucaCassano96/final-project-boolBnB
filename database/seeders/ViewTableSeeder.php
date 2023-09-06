<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\View;
use App\Models\Apartment;


class ViewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* View :: factory() -> count(20) -> create(); */

        $apartments = Apartment :: all();
        $views = View :: factory() -> count(count($apartments)) -> make();

        for ($x=0;$x<count($apartments);$x++) {

            $apartment = $apartments[$x];
            $view = $views[$x];

            $view -> apartment_id = $apartment -> id;
            $view -> save();
        }
    }
}
