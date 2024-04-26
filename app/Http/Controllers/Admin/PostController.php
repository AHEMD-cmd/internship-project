<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\PostFilter;
use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PostResource;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;

class PostController extends Controller
{
    public function index(PostFilter $filters)
    {
        return PostResource::collection(Post::filter($filters)->with('user')->paginate(10));
    }

    public function show(POST $post)
    {
        $post->load('user', 'comments', 'images');

        return new PostResource($post);
    }

    public function store(StorePostRequest $request)
    {
        return response([
            'message' => __('post.create'),
            'post' => new PostResource($request->build())
        ], 201);
    }

    public function update(UpdatePostRequest $request, POST $post)
    {
        return response([
            'message' => __('post.update'),
            'post' => new PostResource($request->build())
        ]);
    }

    public function destroy(POST $post)
    {
        $post->remove(); // handle the deletion of the relationships with the posts
        $post->delete();

        return response([
            'message' => auth()->user()->id != $post->user_id ? __('auth.unauthorize') : __('post.delete')
        ]);
    }
}
