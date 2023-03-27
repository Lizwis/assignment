<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Post; // use App\Models instead of App
use App\Models\Comment;
use App\Models\User;
use App\Models\Category;




class PostsTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method_returns_paginated_post_collection_with_comments()
    {
        // Create test data
        $category = Category::factory()->count(10)->create();
        $users = user::factory()->count(10)->create();

        $posts = Post::factory()->count(10)->create();

        foreach ($posts as $post) {
            Comment::factory()->count(5)->create(['post_id' => $post->id, 'user_id' => $post->id]);
        }

        // Call the all method
        $response = $this->get('/api/post/all');

        // Assert the response
        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure([
            'data' => [
                [

                    'id',
                    'title',
                    'content',
                    'category_id',
                    'user_id',
                    'created_at',
                    'updated_at',
                    'comments' => [
                        '*' => [
                            'id',
                            'user_id',
                            'post_id',
                            'content',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                ],
            ],
            'links',
            'meta',
        ]);
    }

    public function test_show_method_returns_correct_post_data()
    {
        $category = Category::factory()->create();
        $user = user::factory()->create();

        $post = Post::factory()->create(['category_id' => $category->id, 'user_id' => $user->id]);

        $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);

        $response = $this->get("/api/post/show/{$post->id}");

        $response->assertJson([
            'data' => [

                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'category_id' => $category->id,
                'user_id' => $user->id,
                'comments' => [
                    [
                        'id' => $comment->id,
                        'user_id' => $user->id,
                        'post_id' => $post->id,
                        'content' => $comment->content
                    ]
                ]
            ],
        ]);
    }
}
