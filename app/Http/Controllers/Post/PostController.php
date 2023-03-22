<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Repositories\Post\PostRepositoryInterface;

use App\Http\Controllers\Controller;


class PostController extends Controller
{
    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $posts = $this->postRepository->all();

        return $posts;
    }

    public function show($postId)
    {

        $post = $this->postRepository->findPostByid($postId);

        return $post;
    }
}
