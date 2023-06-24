<?php
namespace App\Services;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Branch;

class BranchService
{
	private $entityManager;

	public function __construct($entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function create(
		$data =	[
			"name" => "",
			"id"	 => 0,
            "address" => "",
		]
	) {
		$existingBranch = $this->entityManager->getRepository(Branch::class)->findOneBy([
			"id"	=> $data["id"]
		]);
		if ($existingBranch) {
			return $existingBranch;
		}
		$branch = new Branch($data);
		$this->entityManager->persist($branch);
		$this->entityManager->flush();
		return $branch;
	}

	public function getBranches()
    {
		$branchRepository = $this->entityManager->getRepository(Branch::class);
		$branch = $branchRepository->findAll();
		return $branch;
	}

	public function getById($id)
	{
		print($id);
		$branch = $this->entityManager->getRepository(Branch::class)->find($id);
		return $branch;
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