<?php

declare(strict_types=1);
namespace App\Service;


use App\Repository\SellerRepository;

class SellerService
{
    /**
     * @var SellerRepository
     */
    private $sellerRepository;

    public function __construct(SellerRepository $sellerRepository)
    {
        $this->sellerRepository = $sellerRepository;
    }
}