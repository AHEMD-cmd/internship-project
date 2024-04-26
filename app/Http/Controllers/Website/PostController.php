<?php

namespace App\Http\Controllers\Website;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Filters\Website\PostFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Website\PostResource;


class PostController extends Controller
{
    public function index(PostFilter $filters)
    {
        return PostResource::collection(Post::with('user')->where('is_visible', 1)->filter($filters)->paginate(5));
    }

    public function show(POST $post)
    {
        if (!$post->visible()) {
            abort(404);
        }

        $post->load('user', 'comments', 'images');

        return new PostResource($post);
    }
}
