<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FavoriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"="favotire:collection"},
 *     denormalizationContext={"groups"="favorite:write"},
 *     openapiContext={
 *     "post"={"security"="is_granted('ROLE_ADMIN','ROLE_USER')"}
 *     },
 *      itemOperations={
 *       "put"={"security"="is_granted('ROLE_ADMIN') or object.getUser()==user"},
 *       "delete"={"security"="is_granted('ROLE_ADMIN') or object.getUser()==user"},
 *       "patch"={"security"="is_granted('ROLE_ADMIN') or object.getUser()==user"},
 *       "get"={
 *          "normalization_context"={"groups"={"favotire:item","favotire:collection"}},
 *          "security"="is_granted('ROLE_ADMIN') or object.getUser()==user"
 *        }
 *      }
 *     )
 * @ORM\Entity(repositoryClass=FavoriteRepository::class)
 */
class Favorite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"favotire:collection"})
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="favorites")
     * @Groups({"favotire:item","favorite:write"})
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="favorite", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"favotire:collection","favorite:write"})
     */
    private $user;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addFavorites($this);
        }
        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)){
            $this->products->removeElement($product);

        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        if($this->user===null){
            $this->user = $user;
        }

        return $this;
    }
}
