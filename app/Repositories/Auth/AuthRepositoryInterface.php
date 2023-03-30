<?php

namespace App\Repositories\Auth;


interface AuthRepositoryInterface
{
    public function register();
    public function login();
    public function logout();
}
