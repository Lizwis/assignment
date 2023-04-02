<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Http\Controllers\ConstructorTrait;


class UserController extends Controller
{
    use ConstructorTrait;


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
