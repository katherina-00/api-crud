<?php
namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="Branch")
     * @ORM\JoinColumn(name="branch_id", referencedColumnName="id")
     */
    private $branch;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    public function __construct(
		$data = [
            'title' => '',
            'price' => 0,
            'brand' => ''
        ]
	) {
		$this->title = $data['title'];
        $this->price = $data['price'];
        $this->brand = $data['brand'];
	}

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function getBranch()
    {
        return $this->branch;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function setBranch(Branch $branch): void
    {
        $this->branch = $branch;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'brand' => $this->brand,
            'branch' => $this->branch,
            'category' => $this->category 
        ]; 
    }
}
