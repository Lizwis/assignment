<?php

namespace App\Repositories\Comment;

use App\Repositories\Comment\CommentRepositoryInterface;
use App\Http\Resources\CommentResource;
use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    public function findCommentByid($commentId)
    {
        $comment = Comment::where('id', $commentId)->firstOrFail();
        return new CommentResource($comment);
    }

    public function deleteComment($commentId)
    {
        $post = Comment::where('id', $commentId)->firstOrFail();

        $post->delete();

        return "comment deleted successfully!";
    }
}
