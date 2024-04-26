<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CatBreadController extends Controller
{
    public function catBreeds()
    {
        return Cache::remember('cat-breeds', now()->addMinutes(60 * 24), function () {
            return Http::get('https://catfact.ninja/breeds')->json();
        });
    }
}
