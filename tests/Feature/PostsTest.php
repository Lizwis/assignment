<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Models\Category;




class PostsTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method_returns_paginated_post_collection_with_comments()
    {
        // Create test data
        $user = user::factory()->create();

        $category = Category::factory()->create();

        $posts = Post::factory()->count(10)->create(['category_id' => $category->id, 'user_id' => $user->id]);

        foreach ($posts as $post) {
            Comment::factory()->count(5)->create(['post_id' => $post->id, 'user_id' => $user->id]);
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
    public function test_create_post()
    {

        $user = user::factory()->create();
        $category = Category::factory()->create();

        $data = [
            'title' => 'Test Title',
            'content' => 'Test Content',
            'category_id' => $category->id
        ];
        $response = $this->actingAs($user)->post('/api/post/store', $data);
        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'title' => $data['title'],
                'content' => $data['content'],
                'user_id' => $user->id,
                'category_id' => $category->id
            ]
        ]);
    }


    /** @test */
    public function it_updates_a_post()
    {

        $category = Category::factory()->create();
        $user = user::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id, 'category_id' => $category->id]);

        $response =  $this->actingAs($user)->post("/api/post/update/{$post->id}", [
            'title' => 'New Title',
            'content' => 'New Content',
            'category_id' => $category->id,
        ]);


        $response->assertStatus(201);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'New Title',
            'content' => 'New Content',
        ]);
    }

    public function test_delete_post()
    {
        $category = Category::factory()->create();
        $user = user::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id, 'category_id' => $category->id]);

        $response = $this->actingAs($user)->post('/api/post/delete/' . $post->id);

        $response->assertStatus(201);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
