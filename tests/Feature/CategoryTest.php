<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{

    use RefreshDatabase;


    public function test_it_can_show_all_categories()
    {
        // arrange
        $categories = Category::factory()->count(3)->create();

        // act
        $response = $this->get('/api/category/all');

        // assert
        $response->assertStatus(200);
    }


    public function test_it_can_find_a_category_by_id()
    {
        // arrange
        $category = Category::factory()->create();

        // act
        $response = $this->get('/api/category/show/' . $category->id);

        // assert
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
            ]
        ]);
    }
}
