<?php

namespace App\Repositories\Comment;


interface CommentRepositoryInterface
{

    public function findCommentByid($commentId);
    public function deleteComment($commentId);
}
