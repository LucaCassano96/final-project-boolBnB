<?php
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Sponsor;
use App\Models\ApartmentSponsor;

class ApartmentSponsorSeeder extends Seeder
{
    public function run()
    {
        $apartments = Apartment::all();
        $sponsors = Sponsor::all();

        $apartments->each(function ($apartment) use ($sponsors) {
            $sponsor = $sponsors->random();
            $start_date = now()->subDays(rand(1, 30)); // Random date within the last 30 days
            $end_date = now()->addDays(rand(31, 180)); // Random date within the next 180 days

            ApartmentSponsor::create([
                'apartment_id' => $apartment->id,
                'sponsor_id' => $sponsor->id,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
        });
    }
}
