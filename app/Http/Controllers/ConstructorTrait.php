<?php

namespace App\Http\Controllers;

use App\Services\ApiLogger;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Auth\AuthRepositoryInterface;


trait ConstructorTrait
{

    private $logger, $categoryRepository, $commentRepository,
        $postRepository, $userRepository, $authRepository;


    public function __construct(
        ApiLogger $logger,
        CategoryRepositoryInterface $categoryRepository,
        CommentRepositoryInterface $commentRepository,
        PostRepositoryInterface $postRepository,
        UserRepositoryInterface $userRepository,
        AuthRepositoryInterface $authRepository
    ) {
        $this->logger = $logger;
        $this->categoryRepository = $categoryRepository;
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->authRepository = $authRepository;
    }
}
