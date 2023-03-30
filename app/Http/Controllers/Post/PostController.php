<?php

namespace App\Http\Controllers\Post;

use App\Repositories\Post\PostRepositoryInterface;

use App\Http\Controllers\Controller;
use App\Services\ApiLogger;
use Illuminate\Http\Response;

use App\Http\Requests\StorePostRequest;

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

    public function store(StorePostRequest $request)
    {
        $createPost = $this->postRepository->createPost($request);

        $this->saveLogs($createPost);

        return $createPost->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update($post_id, StorePostRequest $request)
    {
        $updatePost = $this->postRepository->updatePost($post_id, $request);

        $this->saveLogs($updatePost);

        return $updatePost->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function delete($post_id)
    {
        $post = $this->postRepository->deletePost($post_id);

        return response($post, Response::HTTP_CREATED);
    }


    private function saveLogs($data)
    {
        $response = new Response([$data]);
        $responseContent = $response->getContent();

        $this->logger->log(request()->url(), $responseContent);
    }
}
