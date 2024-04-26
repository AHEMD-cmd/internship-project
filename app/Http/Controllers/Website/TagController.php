<?php

namespace App\Http\Controllers\Website;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Filters\Website\TagFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Website\TagResource;
use App\Http\Requests\Website\StoreTagRequest;
use App\Http\Requests\Website\UpdateTagRequest;

class TagController extends Controller
{
    public function index(TagFilter $filters)
    {
        return TagResource::collection(Tag::visible(true)->filter($filters)->paginate(5));
    }

    public function show(Tag $tag)
    {
        if (!$tag->visible()) {
            abort(404);
        }

        $tag->load('places');

        return new TagResource($tag);
    }
}
