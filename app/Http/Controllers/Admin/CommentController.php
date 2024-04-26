<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CommentResource;
use App\Http\Requests\Admin\StoreCommentRequest;
use App\Http\Requests\Admin\UpdateCommentRequest;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        return CommentResource::collection($post->comments()->paginate(5));
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
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response([
            'message' => __('comment.delete')
        ]);
    }
}
