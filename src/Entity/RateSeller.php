<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RateSellerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"="rateSeller:collection"},
 *     denormalizationContext={"groups"="rateSeller:write"},
 *     itemOperations={
 *     "put",
 *     "delete",
 *     "patch",
 *     "get"={
 *           "normalization_context"=
 *            {"groups"={"rateSeller:item","rateSeller:collection"}}
 *       }
 *     }
 * )
 * @ORM\Entity(repositoryClass=RateSellerRepository::class)
 */
class RateSeller
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"rateSeller:collection,rateSeller:write}"})
     */
    private $numberStars;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rateSellers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"rateSeller:item","rateSeller:collection","rateSeller:write"})
     */
    private $_user;

    /**
     * @ORM\ManyToOne(targetEntity=Seller::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"rateSeller:item","rateSeller:collection","rateSeller:write"})
     */
    private $seller;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberStars(): ?int
    {
        return $this->numberStars;
    }

    public function setNumberStars(int $numberStars): self
    {
        $this->numberStars = $numberStars;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->_user;
    }

    public function setUser(?User $_user): self
    {
        $this->_user = $_user;

        return $this;
    }

    public function getSeller(): ?Seller
    {
        return $this->seller;
    }

    public function setSeller(?Seller $seller): self
    {
        $this->seller = $seller;

        return $this;
    }
}
