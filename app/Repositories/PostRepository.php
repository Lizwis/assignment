<?php

namespace App\Repositories;

use App\Models\Post;

use App\Repositories\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function all()
    {
        return Post::all();
    }

    public function findPostByid($postId)
    {
        return Post::where('id', $postId)->firstOrFail();
    }
}
