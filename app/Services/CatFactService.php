<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CatFactService
{
    public function getCatFacts($request)
    {
        $cacheKey = 'cat-facts-' . serialize($request->only(['max_length', 'limit']));

        return Cache::remember($cacheKey, now()->addMinutes(60 * 24), function () {

            return Http::get('https://catfact.ninja/facts', [
                'max_length' => request()->max_length,
                'limit' => request()->limit
            ])->json();
        });
    }
}
