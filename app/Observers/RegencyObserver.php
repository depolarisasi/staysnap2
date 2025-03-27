<?php

namespace App\Observers;
use App\Models\Regency;
use Illuminate\Support\Facades\Cache;

class RegencyObserver
{
    public function saved(Regency $regency)
{
    Cache::forget('regencies.'.$regency->province_id);
}
}
