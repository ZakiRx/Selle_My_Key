<?php

declare(strict_types=1);
namespace App\Service;


use App\Repository\OrderRepository;

class OrderService
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
}