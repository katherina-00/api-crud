<?php
namespace App\Services;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Category;

class CategoryService
{
	private $entityManager;

	public function __construct($entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function create(
		$data =	[
			"name" => "",
			"id"	 => 0
		]
	) {
		$existingCategory = $this->entityManager->getRepository(Category::class)->findOneBy([
			"id"	=> $data["id"]
		]);
		if ($existingCategory) {
			return $existingCategory;
		}
		$category = new Category($data);
		$this->entityManager->persist($category);
		$this->entityManager->flush();
		return $category;
	}

	public function getCategories()
    {
		$categoryRepository = $this->entityManager->getRepository(Category::class);
		$category = $categoryRepository->findAll();
		return $category;
	}

	public function getById($id)
	{
		print($id);
		$category = $this->entityManager->getRepository(Category::class)->find($id);
		return $category;
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
}