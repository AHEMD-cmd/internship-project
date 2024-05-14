<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\CatFactIndexRequest;
use App\Http\Requests\Website\CatFactShowRequest;
use App\Services\CatFactService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CatFactController extends Controller
{

    public function index(CatFactIndexRequest $request, CatFactService $catFactService)
    {
        return $catFactService->getCatFacts($request);
    }
}
