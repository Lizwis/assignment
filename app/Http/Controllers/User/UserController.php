<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Repositories\User\UserRepositoryInterface;

class UserController extends Controller
{

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function show($user_id)
    {
        $posts = $this->userRepository->getUserByid($user_id);

        return $posts;
    }
}
