<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CatFactController extends Controller
{

    public function index()
    {
        $cacheKey = 'cat-facts-' . serialize(request()->only(['max_length', 'limit']));

        return Cache::remember($cacheKey, now()->addMinutes(60 * 24), function () {

            return Http::get('https://catfact.ninja/facts', [
                'max_length' => request()->max_length,
                'limit' => request()->limit
            ])->json();
        });
    }

    public function catFact()
    {
        // Filter cat facts with length
        $filteredFacts = collect($this->index()['data'])->filter(function ($fact) {
            if ($fact['length'] <= request()->max_length) {
                return $fact;
            }
        });

        if ($filteredFacts->isEmpty()) {
            return response([
                'message' => __('cat_fact.not_found', ['length' => request()->max_length])
            ], 203);
        }

        return $filteredFacts->random();
    }
}
