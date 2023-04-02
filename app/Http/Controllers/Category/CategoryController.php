<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ConstructorTrait;

use Illuminate\Http\Response;


class CategoryController extends Controller
{
    use ConstructorTrait;

    public function index()
    {
        $categories = $this->categoryRepository->showAll();
        $this->saveLogs($categories);

        return $categories->response()
            ->setStatusCode(Response::HTTP_OK);;
    }

    public function show($category_id)
    {
        $category = $this->categoryRepository->findById($category_id);
        $this->saveLogs($category);
    }

    private function saveLogs($data)
    {
        $response = new Response([$data]);
        $responseContent = $response->getContent();

        $this->logger->log(request()->url(), $responseContent);
    }
}
