<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Branch;
use App\Services\BranchService;

class BranchController
{
    private $branchService;
    private $app;
	private $entityManager;

    public function __construct($app, $entityManager)
    {
        $this->app = $app;
		$this->entityManager = $entityManager;
        $this->branchService = new BranchService($entityManager);

    }

    public function buildRoutes()
    {
        $this->app->get('/branches', [$this, 'getAll']);
        $this->app->get('/branches/{id}', [$this, 'getById']);
    }

    public function getAll(Request $request, Response $response, $args)
	{
		$list = json_encode($this->branchService->getBranches(), JSON_PRETTY_PRINT);
		$response->getBody()->write($list);
		return $response;
	}
    public function getById(Request $request, Response $response, $args)
    {
            $id = $args['id'];
            $branch = json_encode($this->branchService->getById($id), JSON_PRETTY_PRINT);
            $response->getBody()->write($branch);  
            return $response;
    }
}
