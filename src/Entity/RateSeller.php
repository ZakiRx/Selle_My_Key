<?php

namespace App\Entity;

use App\Repository\RateSellerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
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
     */
    private $numberStars;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rateSellers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $_user;

    /**
     * @ORM\ManyToOne(targetEntity=Seller::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
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
