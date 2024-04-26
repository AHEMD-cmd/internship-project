<?php

namespace App\Http\Controllers\Website;

use App\Models\Specification;
use App\Http\Controllers\Controller;
use App\Filters\Website\SpecificationFilter;
use App\Http\Resources\Website\SpecificationResource;
use App\Http\Requests\Website\StoreSpecificationRequest;
use App\Http\Requests\Website\UpdateSpecificationRequest;

class SpecificationController extends Controller
{
    public function index(SpecificationFilter $filters)
    {
        return SpecificationResource::collection(Specification::filter($filters)->paginate(5));
    }

    public function show(Specification $specification)
    {
        return new SpecificationResource($specification);
    }
}
