<?php

namespace App\Http\Controllers\Post;

use App\Repositories\Post\PostRepositoryInterface;

use App\Http\Controllers\Controller;
use App\Services\ApiLogger;
use Illuminate\Http\Response;

use App\Http\Resources\PostsResource;
use App\Models\Post;


class PostController extends Controller
{
    private $postRepository, $logger;


    public function __construct(PostRepositoryInterface $postRepository, ApiLogger $logger)
    {
        $this->postRepository = $postRepository;
        $this->logger = $logger;
    }

    public function index()
    {
        $posts = $this->postRepository->all();
        $this->saveLogs($posts);

        return $posts->response()
            ->setStatusCode(Response::HTTP_OK);;
    }

    public function show($postId)
    {
        $post = $this->postRepository->findPostByid($postId);

        $this->saveLogs($post);

        return $post->response()
            ->setStatusCode(Response::HTTP_OK);
    }


    private function saveLogs($data)
    {
        $response = new Response([$data]);
        $responseContent = $response->getContent();

        $this->logger->log(request()->url(), $responseContent);
    }
}
