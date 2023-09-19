<?php

namespace App\Observers;
use App\Models\Sponsor;

class SponsorObserver
{
    public function updated(Sponsor $sponsor)
    {
        if ($sponsor->end_date <= now()) {
            $sponsor->apartment->update(['sponsor' => 0]);
        }
    }
}
