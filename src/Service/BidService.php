<?php


namespace App\Service;


use App\Repository\BidRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BidService
{
    private $bidRepository;

    public function __construct(BidRepository $bidRepository)
    {
        $this->bidRepository = $bidRepository;
    }

}