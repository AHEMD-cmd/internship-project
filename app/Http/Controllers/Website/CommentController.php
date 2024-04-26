<?php

namespace App\Http\Controllers\Website;

use App\Models\Post;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\Website\CommentResource;
use App\Http\Requests\Website\StoreCommentRequest;
use App\Http\Requests\Website\UpdateCommentRequest;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index');
    }

    public function index(Post $post)
    {
        return CommentResource::collection($post->comments()->paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        return new CommentResource($request->storeComment());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        return response([
            'message' => __('comment.update'),
            'comment' => new CommentResource($request->updateComment())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        if (auth()->user()->id != $comment->user_id) {
            $comment->delete();

            return response([
                'message' => __('comment.delete')
            ]);
        }

        return response([
            'message' =>    __('auth.unauthorize')
        ]);
    }
}
