<?php

namespace App\Entity;

use App\Repository\SellerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SellerRepository::class)
 */
class Seller extends  User
{

    /**
     * @ORM\OneToMany(targetEntity=RateSeller::class, mappedBy="seller", orphanRemoval=true)
     */
    private $ratings;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="seller")
     */
    private $orders;

    public function __construct()
    {
        parent::__construct();
        $this->ratings = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    /**
     * @return Collection|RateSeller[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(RateSeller $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setSeller($this);
        }

        return $this;
    }

    public function removeRating(RateSeller $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getSeller() === $this) {
                $rating->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setSeller($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getSeller() === $this) {
                $order->setSeller(null);
            }
        }

        return $this;
    }
}
