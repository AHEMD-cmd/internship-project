<?php

namespace App\Http\Controllers\Website;

use App\Models\Place;
use Illuminate\Http\Request;
use App\Filters\Website\PlaceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Website\PlaceResource;
use App\Http\Requests\Website\StorePlaceRequest;
use App\Http\Requests\Website\UpdatePlaceRequest;

class PlaceController extends Controller
{
    public function index(PlaceFilter $filters)
    {
        return PlaceResource::collection(Place::visible(true)->filter($filters)->paginate(5));
    }

    public function show(Place $place)
    {
        if (!$place->visible()) {
            abort(404);
        }

        $place->load('specifications', 'images', 'tags');

        return new PlaceResource($place);
    }
}
