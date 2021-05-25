<?php

declare(strict_types=1);
namespace App\Service;


use App\Repository\PurchaseRepository;

class PurchaseService
{
    /**
     * @var PurchaseRepository
     */
    private $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

}