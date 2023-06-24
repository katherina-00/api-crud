<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Product;
use App\Services\ProductService;

class ProductController
{

    private $app;
	private $productService;
	private $entityManager;

    public function __construct($app, $entityManager)
	{
		$this->app = $app;
		$this->entityManager = $entityManager;
        $this->productService = new ProductService($entityManager);
	}

    public function buildRoutes()
{
    $this->app->get('/', [$this, 'welcome']);
    $this->app->get('/products', [$this, 'getAll']);
    $this->app->get('/products/{id}', [$this, 'getById']);
    $this->app->get('/productsByCategory/{id}', [$this, 'getByCategoryId']);
    $this->app->get('/productsByBranch/{id}', [$this, 'getByBranchId']);
    $this->app->post('/products', [$this, 'create']);
    $this->app->put('/products/{id}', [$this, 'update']);
    $this->app->delete('/products/{id}', [$this, 'delete']);
}

public function welcome(Request $request, Response $response, $args)
{
    $response->getBody()->write('Welcome to the API');
    return $response;
}

public function getAll(Request $request, Response $response, $args)
	{
		$list = json_encode($this->productService->getProducts(), JSON_PRETTY_PRINT);
		$response->getBody()->write($list);
		return $response;
	}

public function getById(Request $request, Response $response, $args)
{
        $id = $args['id'];
		$product = json_encode($this->productService->getProduct($id), JSON_PRETTY_PRINT);
		$response->getBody()->write($product);
		return $response;
}

public function getByCategoryId(Request $request, Response $response, $args)
{
        $id = $args['id'];
		$product = json_encode($this->productService->getProductByCategory($id), JSON_PRETTY_PRINT);
		$response->getBody()->write($product);
		return $response;
}

public function getByBranchId(Request $request, Response $response, $args)
{
        $id = $args['id'];
		$product = json_encode($this->productService->getProductByBranch($id), JSON_PRETTY_PRINT);
		$response->getBody()->write($product);
		return $response;
}

public function create(Request $request, Response $response, $args)
{
    {
		$product = json_decode($request->getBody(), true);
		$product = json_encode($this->productService->create($product), JSON_PRETTY_PRINT);
		$response->getBody()->write($product);
		return $response;
	}
}

public function update(Request $request, Response $response, $args)
{
    $productId = $args['id'];
    $productData = json_decode($request->getBody(), true);
    $updatedproduct = $this->productService->updateProduct($productId, $productData);
    $response->getBody()->write(json_encode($updatedproduct, JSON_PRETTY_PRINT));
    return $response;
}

public function delete(Request $request, Response $response, $args)
{
    $productId = $args['id'];
    $this->productService->deleteproduct($productId);
    return $response->withStatus(204); // No Content
}
}
