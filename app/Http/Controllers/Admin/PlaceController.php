<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\PlaceFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePlaceRequest;
use App\Http\Requests\Admin\UpdatePlaceRequest;
use App\Http\Resources\Admin\PlaceResource;
use App\Models\Place;

class PlaceController extends Controller
{
    public function index(PlaceFilter $filters)
    {
        return PlaceResource::collection(Place::filter($filters)->paginate(5));
    }

    public function show(Place $place)
    {
        $place->load('specifications', 'images');

        return new PlaceResource($place);
    }

    public function store(StorePlaceRequest $request)
    {
        return response([
            'message' => __('place.create'),
            'post' => new PlaceResource($request->build())
        ], 201);
    }

    public function update(UpdatePlaceRequest $request, Place $place)
    {
        return response([
            'message' => __('place.update'),
            'place' => new PlaceResource($request->update())
        ]);
    }

    public function destroy(Place $place)
    {
        $place->remove(); //handle the deletion of the relationships with the places
        $place->delete();

        return response([
            'message' => __('place.delete')
        ]);
    }
}
