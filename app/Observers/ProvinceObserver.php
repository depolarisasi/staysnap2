<?php

namespace App\Observers;
use App\Models\Province;
use Illuminate\Support\Facades\Cache;

class ProvinceObserver
{
    public function saved(Province $province)
{
    Cache::forget('provinces.all');
}

}
