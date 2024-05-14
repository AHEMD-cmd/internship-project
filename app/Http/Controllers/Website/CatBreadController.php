<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CatBreedService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CatBreadController extends Controller
{
    public function index(CatBreedService $catBreedService)
    {
        return $catBreedService->getCatbreeds();
    }
}
