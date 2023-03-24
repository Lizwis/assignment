<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\ApiLogger;


class UserController extends Controller
{

    private $userRepository, $logger;

    public function __construct(UserRepositoryInterface $userRepository, ApiLogger $logger)
    {
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    public function show($user_id)
    {
        $user = $this->userRepository->getUserByid($user_id);

        $this->saveLogs($user);

        return $user->response()
            ->setStatusCode(Response::HTTP_OK);
    }


    private function saveLogs($data)
    {
        $response = new Response([$data]);
        $responseContent = $response->getContent();

        $this->logger->log(request()->url(), $responseContent);
    }
}
