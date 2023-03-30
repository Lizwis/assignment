<?php

namespace App\Repositories\Post;


interface PostRepositoryInterface
{
    public function all();
    public function findPostByid($postId);
    public function createPost($request);
}
