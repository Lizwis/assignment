<?php

namespace App\Repositories\Post;


interface PostRepositoryInterface
{
    public function all();
    public function getUser($user_id);
    public function findPostByid($postId);
}
