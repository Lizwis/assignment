<?php

namespace App\Repositories\Post;

use App\Repositories\Post\PostRepositoryInterface;
use App\Http\Resources\PostsResource;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{

    public function all()
    {
        $posts = Post::with('comments')->paginate(5);
        $postsCollection =  PostsResource::collection($posts);

        return $postsCollection;
    }

    public function findPostByid($postId)
    {
        $post = Post::where('id', $postId)->firstOrFail();
        $postCollection =   new PostsResource($post);

        return $postCollection;
    }
}
