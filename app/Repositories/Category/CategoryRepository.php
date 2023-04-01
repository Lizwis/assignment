<?php

namespace App\Repositories\Category;

use App\Models\Category;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Resources\UserResource;


class CategoryRepository implements CategoryRepositoryInterface
{
    public function showAll()
    {
        $categories = Category::get();
        return $categories;
    }
    public function findById($category_id)
    {
        $category = Category::where('id', $category_id)->first();
        return $category;
    }
}
