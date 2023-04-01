<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Services\ApiLogger;
use Illuminate\Http\Response;


class CategoryController extends Controller
{
    private $categoryRepository, $logger;


    public function __construct(CategoryRepositoryInterface $categoryRepository, ApiLogger $logger)
    {
        $this->categoryRepository = $categoryRepository;
        $this->logger = $logger;
    }

    public function index()
    {
        $categories = $this->categoryRepository->showAll();
        $this->saveLogs($categories);

        // return $categories->response()
        //     ->setStatusCode(Response::HTTP_OK);;
        return response()->json($categories, Response::HTTP_OK);
    }

    public function show($category_id)
    {
        $category = $this->categoryRepository->findById($category_id);
        $this->saveLogs($category);
        return response()->json($category, Response::HTTP_OK);
    }

    private function saveLogs($data)
    {
        $response = new Response([$data]);
        $responseContent = $response->getContent();

        $this->logger->log(request()->url(), $responseContent);
    }
}
