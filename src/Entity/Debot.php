<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"dobot:collection"}},
 *     denormalizationContext={"groups"={"debot:write"}}
 * )
 * Class Debot
 * @package App\Entity
 *
 */
class Debot
{

    private  $id;
    /**
     * @Groups({debot:write})
     */
    private  $balnce;
    private $result;

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
    public function getBalnce()
    {
        return $this->balnce;
    }

    /**
     * @param mixed $balnce
     */
    public function setBalnce($balnce): void
    {
        $this->balnce = $balnce;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }





}