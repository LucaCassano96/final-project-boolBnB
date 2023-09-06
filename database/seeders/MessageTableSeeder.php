<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Apartment;


class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Message :: factory() -> count(30) -> create(); */

        $messages = Message :: factory() -> count(30) -> make();

        foreach ($messages as $message) {

            $apartment = Apartment :: inRandomOrder() -> first();

            $message -> apartment_id = $apartment -> id;
            $message -> save();
        }
    }
}
