<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\User;

class UserTest extends TestCase
{

    use RefreshDatabase;

    public function test_show_user()
    {
        // Create a new user
        $user = User::factory()->create();

        // Call the show method on the user controller
        $response = $this->get('/api/user/show/' . $user->id);

        // Assert that the response has an HTTP status code of 200
        $response->assertStatus(Response::HTTP_OK);

        // Assert that the response has the correct user data
        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }
}
