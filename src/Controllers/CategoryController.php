<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Category;
use App\Services\CategoryService;

class CategoryController
{
    private $categoryService;
    private $app;
	private $entityManager;

    public function __construct($app, $entityManager)
    {
        $this->app = $app;
		$this->entityManager = $entityManager;
        $this->categoryService = new CategoryService($entityManager);

    }

    public function buildRoutes()
    {
        $this->app->get('/categories', [$this, 'getAll']);
        $this->app->get('/categories/{id}', [$this, 'getById']);
    }

    public function getAll(Request $request, Response $response, $args)
	{
		$list = json_encode($this->categoryService->getCategories(), JSON_PRETTY_PRINT);
		$response->getBody()->write($list);
		return $response;
	}
    public function getById(Request $request, Response $response, $args)
    {
            $id = $args['id'];
            $category = json_encode($this->categoryService->getById($id), JSON_PRETTY_PRINT);
            $response->getBody()->write($category);  
            return $response;
    }
}
