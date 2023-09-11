<?php

namespace Database\Seeders;

use App\Models\View;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this -> call([
            UserTableSeeder :: class,
            ApartmentTableSeeder :: class,
            AmenityTableSeeder :: class,
            MessageTableSeeder :: class,
            ViewTableSeeder :: class,
            SponsorTableSeeder :: class,
        ]);
    }
}
