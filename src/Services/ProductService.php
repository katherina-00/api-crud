<?php
namespace App\Services;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;

class ProductService
{
	private $entityManager;
	private $categoryService;

	public function __construct($entityManager)
	{
		$this->entityManager = $entityManager;
		$this->categoryService = New CategoryService($entityManager);
	}


public function create($productData = [
    "title" => "",
    "price" => 0,
    "brand" => "",
	"categoryId" => null,
	"branchId" => null
])
{

    $productInfo = [
        'title' => $productData['title'],
        'price' => $productData['price'],
        'brand' => $productData['brand'],
    ];

    $newProduct = new Product($productInfo);
    $this->entityManager->persist($newProduct);

	//cambio aqui
	if (isset($productData['categoryId'])) {
		$this->addCategory($newProduct, $productData['categoryId']);
	}
	if (isset($productData['branchId'])) {
		$this->addBranch($newProduct, $productData['branchId']);
	}
	
    $this->entityManager->flush();

    return $newProduct;
}

public function updateProduct($productId, $productData) {
    $product = $this->getProduct($productId);
    if (!$product) {
        // Lanza una excepción, devuelve un mensaje de error o realiza cualquier otra acción que consideres apropiada
        throw new \Exception('product not found.');
    }

    $product->setTitle($productData['title']);
    $product->setPrice($productData['price']);
    $product->setBrand($productData['brand']);

	if (isset($productData['categoryId'])) {
		$this->addCategory($product, $productData['categoryId']);
	}
	if (isset($productData['branchId'])) {
		$this->addBranch($product, $productData['branchId']);
	}
    $this->entityManager->persist($product);
    $this->entityManager->flush();

    return $product;
}


public function delete($productId)
	{
		$response = [];

		$product = $this->getproduct($productId);
		if (!$product) {
			$response['success'] = false;
			$response['message'] = 'product ' . $productId . ' not found.';
			return $response;
		}

		$this->entityManager->remove($product);
		$this->entityManager->flush();
		$response = [
			'success' => true,
			'message' => 'product deleted successfully',
			'data' => [
				'id' => $productId
			]
		];
		return $response;
	}

    public function getproduct($id)
	{
		$productRepository = $this->entityManager->getRepository(Product::class);
		$product = $productRepository->find($id);
		
		return $product;
	}

	public function getproductByCategory($category_id)
	{
		$productRepository = $this->entityManager->getRepository(Product::class);
		$product = $productRepository->findBy(['category'=>$category_id]);
		
		return $product;
	}

	public function getproductByBranch($branch_id)
	{
		$productRepository = $this->entityManager->getRepository(Product::class);
		$product = $productRepository->findBy(['branch'=>$branch_id]);
		
		return $product;
	}


	public function getproducts()
	{	
		$productRepository = $this->entityManager->getRepository(Product::class);
		$products = $productRepository->findAll();
		return $products;
	}


public function deleteproduct($productId)
{
    $product = $this->getproduct($productId);
    if (!$product) {
        // Lanza una excepción, devuelve un mensaje de error o realiza cualquier otra acción que consideres apropiada
        throw new \Exception('product not found.');
    }

    $this->entityManager->remove($product);
    $this->entityManager->flush();
}


	public function query($pageNumber = 1, $pageSize = 10)
	{
		$offset = ($pageNumber - 1) * $pageSize;
		$dql = "SELECT u FROM App\Models\User u ORDER BY u.name";
		$query = $this->entityManager->createQuery($dql)
			->setFirstResult($offset)
			->setMaxResults($pageSize);
		$users = $query->getResult();
		return $users;
}

public function addCategory($product, $category_id)
{
	$categoryRepository = $this->entityManager->getRepository(Category::class);
    $categoryObject = $categoryRepository->find($category_id);

    if ($categoryObject) {
        $product->setCategory($categoryObject);
	
    } else {
        throw new \Exception('Category not found.');
    }

}
public function addBranch($product, $branch_id)
{
	$branchRepository = $this->entityManager->getRepository(Branch::class);
    $branchObject = $branchRepository->find($branch_id);

    if ($branchObject) {
        $product->setBranch($branchObject);
    } else {
        throw new \Exception('Branch not found.');
    }

}
}