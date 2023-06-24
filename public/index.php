<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/bootstrap.php';

use App\Controllers\BranchController;
use Slim\Factory\AppFactory;
use App\Controllers\ProductController;
use App\Controllers\CategoryController;



if (!isset($entityManager)) {
	echo "Entity manager is not set.\n";
	return;
}

$app = AppFactory::create();
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->addRoutingMiddleware();

/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> Should be set to false in production
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger  
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:4200')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});


$categoryController = new CategoryController($app, $entityManager);
$categoryController->buildRoutes();
$branchController = new BranchController($app, $entityManager);
$branchController->buildRoutes();
$productController = new ProductController($app, $entityManager);
$productController->buildRoutes();

$app->run();