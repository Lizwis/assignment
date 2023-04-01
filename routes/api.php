<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Category\CategoryController;;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'post'], function () {
    Route::get('/all', [PostController::class, 'index']);
    Route::get('/show/{postId}', [PostController::class, 'show']);
    Route::post('/store', [PostController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/update/{postId}', [PostController::class, 'update'])->middleware('auth:sanctum');
    Route::post('/delete/{postId}', [PostController::class, 'delete'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/show/{user_id}', [UserController::class, 'show']);
});

Route::group(['prefix' => 'comment'], function () {
    Route::get('/show/{comment_id}', [CommentController::class, 'show']);
    Route::post('/delete/{comment_id}', [CommentController::class, 'delete'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'category'], function () {
    Route::get('/all', [CategoryController::class, 'index']);
    Route::get('/show/{category_id}', [CategoryController::class, 'show']);
});


Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
