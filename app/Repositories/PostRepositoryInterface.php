<?php

namespace App\Repositories;


interface PostRepositoryInterface
{
    public function all();
    public function findPostByid($postId);
}
