<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RateSellerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"="rateSeller:collection"},
 *     denormalizationContext={"groups"="rateSeller:write"},
 *     collectionOperations={
 *     "get",
 *     "post"={"security"="is_granted('ROLE_USER')"}
 *     },
 *     itemOperations={
 *     "put"={"security"="is_granted('ROLE_ADMIN')"},
 *     "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *     "patch"={"security"="is_granted('ROLE_ADMIN')"},
 *     "get"={
 *           "normalization_context"={"groups"={"rateSeller:item","rateSeller:collection"}},
 *           "security"="is_granted('ROLE_ADMIN') or object.getUser()==user or object.getSeller()==user"
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
     * @Assert\Positive()
     */
    private $numberStars;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rateSellers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"rateSeller:item","rateSeller:collection","rateSeller:write"})
     */
    private $user;

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
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
