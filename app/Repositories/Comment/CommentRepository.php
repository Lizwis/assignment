<?php

namespace App\Repositories\Comment;

use App\Repositories\Comment\CommentRepositoryInterface;
use App\Http\Resources\PostsResource;
use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    public function findCommentByid($commentId)
    {
        $post = Comment::where('id', $commentId)->firstOrFail();

        return $post;
    }

    public function deleteComment($commentId)
    {
        $post = Comment::where('id', $commentId)->firstOrFail();

        $post->delete();

        return "comment deleted successfully!";
    }
}
