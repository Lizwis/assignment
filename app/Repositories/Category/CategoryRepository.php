<?php

namespace App\Repositories\Category;

use App\Models\Category;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Resources\CategoryResource;


class CategoryRepository implements CategoryRepositoryInterface
{
    public function showAll()
    {
        $categories = Category::get();
        return CategoryResource::collection($categories);
    }
    public function findById($category_id)
    {
        $category = Category::where('id', $category_id)->first();
        return new CategoryResource($category);
    }
}
