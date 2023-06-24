<?php
namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $product;


    public function __construct(
		$data = [
			"id"	=> 0,
			"name"	=> "",

		]
	) {
		$this->id = $data["id"];
		$this->name = $data["name"];
        $this->product = new ArrayCollection();
	}


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setproduct(Product $product): void
{
    if (!$this->product->contains($product)) {
        $this->product->add($product);
        $product->setCategory($this);
    }

}

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'id' => $this->id,
          //  'products' => $this->getproduct()->toArray()
        ];
    }

}
