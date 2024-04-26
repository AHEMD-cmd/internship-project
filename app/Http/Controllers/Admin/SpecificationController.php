<?php

namespace App\Http\Controllers\Admin;

use App\Models\Specification;
use App\Http\Controllers\Controller;
use App\Filters\Admin\SpecificationFilter;
use App\Http\Resources\Admin\SpecificationResource;
use App\Http\Requests\Admin\StoreSpecificationRequest;
use App\Http\Requests\Admin\UpdateSpecificationRequest;

class SpecificationController extends Controller
{
    public function index(SpecificationFilter $filters)
    {
        return SpecificationResource::collection(Specification::filter($filters)->paginate(5));
    }

    public function store(StoreSpecificationRequest $request)
    {
        return response([
            'message' => __('specification.create'),
            'post' => new SpecificationResource($request->storeSpecification())
        ], 201);
    }

    public function show(Specification $specification)
    {
        return new SpecificationResource($specification);
    }

    public function update(UpdateSpecificationRequest $request, Specification $Specification)
    {
        return response([
            'message' => __('specification.update'),
            'post' => new SpecificationResource($request->updateSpecification())
        ], 201);
    }

    public function destroy(Specification $specification)
    {
        $specification->remove(); // handle the deletion of the relationships with the specifications
        $specification->delete();

        return response([
            'message' => __('specification.delete')
        ]);
    }
}
