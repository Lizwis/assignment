<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Repositories\Post\PostRepositoryInterface;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        // Create a mock of PostRepositoryInterface and configure it to return a dummy list of posts
        $mockRepository = $this->getMockBuilder(PostRepositoryInterface::class)
            ->getMock();
        $mockRepository->expects($this->once())
            ->method('all')
            ->willReturn(['post1', 'post2']);

        // Bind the mock repository to the app container
        $this->app->instance(PostRepositoryInterface::class, $mockRepository);

        // Call the /post/all route and assert that it returns the dummy list of posts
        $response = $this->get('/api/post/all');
        $response->assertStatus(200);
        $response->assertExactJson(['post1', 'post2']);
    }

    public function testShow()
    {
        $postId = 1;
        $post = ['id' => 1, 'user_id' => 1, 'category_id' => 1, 'title' => 'Test post', 'content' => 'Test body'];

        // Create a mock of PostRepositoryInterface and configure it to return a dummy post
        $mockRepository = $this->getMockBuilder(PostRepositoryInterface::class)
            ->getMock();
        $mockRepository->expects($this->once())
            ->method('findPostByid')
            ->with($postId)
            ->willReturn($post);

        // Bind the mock repository to the app container
        $this->app->instance(PostRepositoryInterface::class, $mockRepository);

        // Call the /post/show/{postId} route with the dummy post ID and assert that it returns the dummy post
        $response = $this->get("/api/post/show/{$postId}");
        $response->assertStatus(200);
        $response->assertExactJson($post);
    }
}
