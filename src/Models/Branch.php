<?php
namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="branch")
 */
class Branch implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="branch", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $product;

    public function __construct(
		$data = [
			"id"	=> 0,
			"name"	=> "",
            "address" => "",

		]
	) {
		$this->id = $data["id"];
		$this->name = $data["name"];
        $this->address = $data["address"];
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

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getproduct()
    {
        return $this->product;
    }

    public function setproduct(Product $product): void
    {
        if (!$this->product->contains($product)) {
            $this->product->add($product);
            $product->setBranch($this);
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
        //    'products' => $this->product,
        ];
    }
}

