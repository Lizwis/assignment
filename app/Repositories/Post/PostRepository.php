<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Models\User;


use App\Repositories\Post\PostRepositoryInterface;
use App\Http\Resources\PostsResource;


class PostRepository implements PostRepositoryInterface
{
    public function all()
    {
        $posts = Post::with('comments')->paginate(5);

        $postsCollection =  PostsResource::collection($posts);

        return response()->json([
            $postsCollection, 200
        ]);
    }

    public function getUser($user_id)
    {
        $user = User::where('id', $user_id)->first();

        return response()->json([
            $user, 200
        ]);
    }


    public function findPostByid($postId)
    {
        return Post::where('id', $postId)->firstOrFail();
    }
}
