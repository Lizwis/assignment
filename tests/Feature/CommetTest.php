<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Category;


class CommetTest extends TestCase
{

    use RefreshDatabase;

    public function test_it_can_find_a_comment_by_id()
    {
        // arrange
        $category = Category::factory()->create();
        $user = user::factory()->create();

        $post = Post::factory()->create(['category_id' => $category->id, 'user_id' => $user->id]);

        $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);

        // act
        $response = $this->get("/api/comment/show/{$comment->id}");

        // assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $comment->id,
            'content' => $comment->content,
            'post_id' => $post->id,
            'user_id' => $user->id
        ]);
    }

    public function test_it_can_delete_a_comment()
    {
        // arrange
        $category = Category::factory()->create();
        $user = user::factory()->create();

        $post = Post::factory()->create(['category_id' => $category->id, 'user_id' => $user->id]);

        $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);

        // act
        $response =  $this->actingAs($user)->post("/api/comment/delete/{$comment->id}");

        // assert
        $response->assertStatus(201);
        $response->assertSee('comment deleted successfully!');
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
