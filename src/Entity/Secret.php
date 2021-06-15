<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\PostSecretController;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"secret:collection"}},
 *     denormalizationContext={"groups"={"secret:write"}},
 *     collectionOperations={
 *     "post"={
 *     "controller"=PostSecretController::class
 *     }
 *     }
 * )
 * Class Secret
 * @package App\Entity
 */
class Secret
{

    private  $id;
    /**
     * @Groups({"secret:write","secret:collection"})
     */
    private  $amount;
    /*
    private $metadata;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     */
    public function setMetadata($metadata): void
    {
        $this->metadata = $metadata;
    }
}