<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sponsor;
use App\Models\Apartment;



class SponsorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Sponsor :: factory() -> count(3) -> create(); */

        $sponsors =  Sponsor :: factory() -> count(3) -> create();

        foreach ($sponsors as $sponsor) {

        $apartments = Apartment :: inRandomOrder() -> limit(rand(0,1)) -> get();

        $sponsor -> apartments() -> attach($apartments);

    }

}}

