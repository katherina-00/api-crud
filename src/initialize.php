<?php
use App\Services\CategoryService;
use App\Services\BranchService;
require_once "bootstrap.php";


if (!isset($entityManager)) {
	echo "Entity manager is not set.\n";
	return;
}

$categoryService = new CategoryService($entityManager);
$branchService = new BranchService($entityManager);
$branch = json_decode(file_get_contents(__DIR__ . '/branch.json'), true);
$categories = json_decode(file_get_contents(__DIR__ . '/category.json'), true);

foreach ($categories as $cat) {
	$categoryService->create($cat);
}
foreach ($branch as $br) {
	$branchService->create($br);
}


