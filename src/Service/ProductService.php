<?php

declare(strict_types=1);
namespace App\Service;


use App\Repository\ProductRepository;

class ProductService
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
}