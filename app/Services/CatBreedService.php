<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CatBreedService
{
    public function getCatbreeds()
    {
        return Cache::remember('cat-breeds', now()->addMinutes(60 * 24), function () {
            return Http::get('https://catfact.ninja/breeds')->json();
        });
    }
}
