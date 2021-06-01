<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DisputeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"="dispute:item"},
 *     denormalizationContext={"groups"="dispute:write"},
 *     collectionOperations={
 *     "get"={"security"="is_granted('ROLE_ADMIN') or object.getPurchase().getBid().getUser()==user"},
 *     "post"={"security"="is_granted('ROLE_ADMIN','ROLE_USER')"}
 *     },
 *     itemOperations={
 *       "put"={"security"="is_granted('ROLE_ADMIN') or object.getPurchase().getBid().getUser()==user"},
 *       "delete"={"security"="is_granted('ROLE_ADMIN') or object.getPurchase().getBid().getUser()==user"},
 *       "patch"={"security"="is_granted('ROLE_ADMIN') or object.getPurchase().getBid().getUser()==user"},
 *       "get"={
 *       "normalization_context"={"groups"={"dispute:item"}},
 *       "security"="is_granted('ROLE_ADMIN') or object.getPurchase().getBid().getUser()==user"
 *       },
 *      }
 *     )
 * @ORM\Entity(repositoryClass=DisputeRepository::class)
 */
class Dispute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("dispute:item")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"dispute:item","dispute:write",})
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     * @Groups({"dispute:item","dispute:write"})
     */
    private $message;

    /**
     * @ORM\OneToOne(targetEntity=Purchase::class, inversedBy="dispute", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"dispute:item","dispute:write"})
     */
    private $purchase;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"dispute:item"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"dispute:item"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="disputes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"dispute:item"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(Purchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
}
