<?php

declare(strict_types=1);
namespace App\Service;


use App\Repository\RateSellerRepository;

class RateSellerService
{
    /**
     * @var RateSellerRepository
     */
    private $rateSellerRepository;

    public function __construct(RateSellerRepository  $rateSellerRepository)
    {
        $this->rateSellerRepository = $rateSellerRepository;
    }
}