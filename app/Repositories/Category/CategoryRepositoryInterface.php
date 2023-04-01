<?php

namespace App\Repositories\Category;


interface CategoryRepositoryInterface
{
    public function showAll();
    public function findById($category_id);
}
