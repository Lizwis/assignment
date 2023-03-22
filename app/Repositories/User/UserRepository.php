<?php

namespace App\Repositories\User;

use App\Models\User;


use App\Repositories\User\UserRepositoryInterface;
use App\Http\Resources\PostsResource;


class UserRepository implements UserRepositoryInterface
{
    public function getUserByid($user_id)
    {
        $user = User::where('id', $user_id)->first();

        return response()->json([
            $user, 200
        ]);
    }
}
