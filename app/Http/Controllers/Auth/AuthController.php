<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Repositories\Auth\AuthRepositoryInterface;
use App\Services\ApiLogger;
use Illuminate\Http\Response;



class AuthController extends Controller
{
    private $authRepository, $logger;


    public function __construct(AuthRepositoryInterface $authRepository, ApiLogger $logger)
    {
        $this->authRepository = $authRepository;
        $this->logger = $logger;
    }


    public function register()
    {
        $newUser = $this->authRepository->register();
        $this->saveLogs($newUser);

        return response()->json($newUser, Response::HTTP_CREATED);
    }


    public function login()
    {
        $login_user = $this->authRepository->login();
        $this->saveLogs($login_user);

        return response()->json($login_user, Response::HTTP_OK);
    }


    public function logout()
    {
        $logout = $this->authRepository->logout();
        $this->saveLogs($logout);

        return response()->json($logout, Response::HTTP_CREATED);
    }


    private function saveLogs($data)
    {
        $response = new Response([$data]);
        $responseContent = $response->getContent();

        $this->logger->log(request()->url(), $responseContent);
    }
}
