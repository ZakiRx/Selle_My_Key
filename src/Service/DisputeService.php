<?php

declare(strict_types=1);

namespace App\Service;


use App\Repository\DisputeRepository;

class DisputeService
{
    /**
     * @var DisputeRepository
     */
    private $disputeRepository;

    public function __construct(DisputeRepository $disputeRepository)
    {
        $this->disputeRepository = $disputeRepository;
    }
}