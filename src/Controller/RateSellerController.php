<?php
declare(strict_types=1);
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RateSellerController extends AbstractController
{
    /**
     * @Route("/rate/seller", name="rate_seller")
     */
    public function index(): Response
    {
        return $this->render('rate_seller/index.html.twig', [
            'controller_name' => 'RateSellerController',
        ]);
    }
}
