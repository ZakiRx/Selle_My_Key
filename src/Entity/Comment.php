<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"comment:collection"}},
 *     denormalizationContext={"groups":"comment:write"},
 *     collectionOperations={
 *     "get",
 *     "post"={"security"="is_granted('ROLE_ADMIN','ROLE_USER')"}
 *     },
 *     itemOperations={
 *     "put"={"security"="is_granted('ROLE_ADMIN') or object.getUser()==user"},
 *     "delete"={"security"="is_granted('ROLE_ADMIN') or object.getUser()==user"},
 *     "patch"={"security"="is_granted('ROLE_ADMIN') or object.getUser()==user"},
 *     "get"={
 *      "normalization_context"={"groups"={"comment:item"}},
 *      "security"="is_granted('ROLE_ADMIN')"
 *     }
 *
 *     }
 * )
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comment:collection","product:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"comment:collection","product:read","comment:item","comment:write"})
     * @Assert\Length(min=2,max=500)
     */
    private $comment;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"comment:collection","comment:item","comment:write"})
     */
    private $enabled;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"comment:collection","comment:item","comment:write"})
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"comment:collection","product:read","comment:item","comment:write"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = true;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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
