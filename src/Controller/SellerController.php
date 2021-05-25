<?php
declare(strict_types=1);
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SellerController extends AbstractController
{
    /**
     * @Route("/seller", name="seller")
     */
    public function index(): Response
    {
        return $this->render('seller/index.html.twig', [
            'controller_name' => 'SellerController',
        ]);
    }
}
