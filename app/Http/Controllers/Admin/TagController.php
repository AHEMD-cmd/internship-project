<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Filters\Admin\TagFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TagResource;
use App\Http\Requests\Admin\StoreTagRequest;
use App\Http\Requests\Admin\UpdateTagRequest;

class TagController extends Controller
{
    public function index(TagFilter $filters)
    {
        return TagResource::collection(Tag::filter($filters)->paginate(5));
    }

    public function store(StoreTagRequest $request)
    {
        return response([
            'message' => __('tag.store'),
            'tag' => new TagResource($request->storeTag())
        ]);
    }

    public function show(Tag $tag)
    {
        $tag->load('places');

        return new TagResource($tag);
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        return response([
            'message' => __('tag.update'),
            'tag' => new TagResource($request->updateTag())
        ]);
    }

    public function destroy(Tag $tag)
    {
        $tag->places()->detach();
        $tag->delete();

        return response([
            'message' => __('tag.delete')
        ]);
    }
}
